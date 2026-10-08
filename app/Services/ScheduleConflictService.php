<?php

namespace App\Services;

use App\Models\CalendarEvent;
use App\Models\CounselingSession;
use Carbon\Carbon;

class ScheduleConflictService
{
    /**
     * Parse a time string into start and end minutes from midnight.
     *
     * @param string|null $startTime
     * @param string|null $endTime
     * @return array [startMinutes, endMinutes]
     */
    public static function parseTimeRange(?string $startTime, ?string $endTime = null): array
    {
        if (empty($startTime)) {
            return [0, 0];
        }

        $cleanStart = trim($startTime);
        $cleanEnd = $endTime ? trim($endTime) : null;

        // 1. Check if startTime contains an embedded range like "09:45 - 10:15" or "(09:45 - 10:15 WIB)"
        if (preg_match('/(\d{1,2})[:.](\d{2})\s*[-–—]\s*(\d{1,2})[:.](\d{2})/', $cleanStart, $rangeMatches)) {
            $sH = (int)$rangeMatches[1];
            $sM = (int)$rangeMatches[2];
            $eH = (int)$rangeMatches[3];
            $eM = (int)$rangeMatches[4];
            return [$sH * 60 + $sM, $eH * 60 + $eM];
        }

        // 2. Check for standard starting time "08:00"
        $startMinutes = 0;
        if (preg_match('/(\d{1,2})[:.](\d{2})/', $cleanStart, $startMatches)) {
            $startMinutes = ((int)$startMatches[1]) * 60 + ((int)$startMatches[2]);
        } elseif (stripos($cleanStart, 'istirahat 1') !== false) {
            $startMinutes = 9 * 60 + 45; // 09:45
            return [$startMinutes, 10 * 60 + 15]; // 10:15
        } elseif (stripos($cleanStart, 'istirahat 2') !== false) {
            $startMinutes = 12 * 60; // 12:00
            return [$startMinutes, 12 * 60 + 45]; // 12:45
        } elseif (stripos($cleanStart, 'pulang') !== false) {
            $startMinutes = 15 * 60; // 15:00
            return [$startMinutes, 16 * 60]; // 16:00
        } elseif (stripos($cleanStart, 'pelajaran bk') !== false) {
            $startMinutes = 10 * 60; // 10:00
            return [$startMinutes, 11 * 60]; // 11:00
        }

        // 3. Determine endMinutes
        $endMinutes = 0;
        if ($cleanEnd && preg_match('/(\d{1,2})[:.](\d{2})/', $cleanEnd, $endMatches)) {
            $endMinutes = ((int)$endMatches[1]) * 60 + ((int)$endMatches[2]);
        }

        if ($endMinutes <= $startMinutes) {
            // Default slot duration: 45 minutes
            $endMinutes = $startMinutes + 45;
        }

        return [$startMinutes, $endMinutes];
    }

    /**
     * Check if two time ranges overlap.
     */
    public static function isTimeOverlap(int $startA, int $endA, int $startB, int $endB): bool
    {
        if ($startA === 0 && $endA === 0) return false;
        if ($startB === 0 && $endB === 0) return false;

        return max($startA, $startB) < min($endA, $endB);
    }

    /**
     * Check for any schedule conflict on a given date and time range.
     *
     * @param string $targetDate YYYY-MM-DD
     * @param string|null $startTime
     * @param string|null $endTime
     * @param array $exclude ['event_id' => ..., 'counseling_id' => ...]
     * @return array|null Returns conflict details or null if no conflict
     */
    public static function checkConflict(
        string $targetDate,
        ?string $startTime,
        ?string $endTime = null,
        array $exclude = []
    ): ?array {
        if (empty($targetDate) || empty($startTime)) {
            return null;
        }

        $parsedDate = date('Y-m-d', strtotime($targetDate));
        [$newStart, $newEnd] = self::parseTimeRange($startTime, $endTime);

        // 1. Cek bentrok dengan Agenda Kalender (CalendarEvent)
        $eventQuery = CalendarEvent::whereDate('event_date', $parsedDate)
            ->where('category', '!=', 'Konseling Individu');

        if (!empty($exclude['event_id'])) {
            $eventQuery->where('id', '!=', $exclude['event_id']);
        }

        $events = $eventQuery->get();
        foreach ($events as $ev) {
            [$evStart, $evEnd] = self::parseTimeRange($ev->start_time, $ev->end_time);

            // Cek kesamaan string langsung atau overlap menit
            $exactMatch = (strtolower(trim($ev->start_time ?? '')) === strtolower(trim($startTime)));
            if ($exactMatch || self::isTimeOverlap($newStart, $newEnd, $evStart, $evEnd)) {
                $timeDisplay = $ev->start_time . ($ev->end_time ? ' - ' . $ev->end_time : '');
                $formattedDate = date('d M Y', strtotime($parsedDate));
                return [
                    'has_conflict'   => true,
                    'type'           => 'event',
                    'id'             => $ev->id,
                    'title'          => $ev->title,
                    'category'       => $ev->category,
                    'time'           => $timeDisplay,
                    'location'       => $ev->location ?? 'Sekolah',
                    'message'        => "Jadwal bentrok dengan agenda: \"{$ev->title}\" ({$timeDisplay}) pada {$formattedDate}.",
                ];
            }
        }

        // 2. Cek bentrok dengan Sesi Konseling (CounselingSession) yang berstatus disetujui atau dijadwalkan ulang
        $counselingQuery = CounselingSession::with('student')
            ->whereDate('preferred_date', $parsedDate)
            ->whereIn('status', ['disetujui', 'dijadwalkan ulang']);

        if (!empty($exclude['counseling_id'])) {
            $counselingQuery->where('id', '!=', $exclude['counseling_id']);
        }

        $counselings = $counselingQuery->get();
        foreach ($counselings as $cs) {
            [$csStart, $csEnd] = self::parseTimeRange($cs->preferred_time);

            $exactMatch = (strtolower(trim($cs->preferred_time ?? '')) === strtolower(trim($startTime)));
            if ($exactMatch || self::isTimeOverlap($newStart, $newEnd, $csStart, $csEnd)) {
                $studentName = $cs->student ? $cs->student->nama : 'Siswa';
                $timeDisplay = $cs->preferred_time;
                $formattedDate = date('d M Y', strtotime($parsedDate));
                return [
                    'has_conflict'   => true,
                    'type'           => 'counseling',
                    'id'             => $cs->id,
                    'title'          => "Konseling dengan {$studentName} ({$cs->category})",
                    'category'       => 'Konseling',
                    'time'           => $timeDisplay,
                    'location'       => $cs->room_or_media ?? 'Ruang BK',
                    'message'        => "Jadwal bentrok dengan sesi konseling: \"{$studentName}\" ({$timeDisplay}) pada {$formattedDate}.",
                ];
            }
        }

        return null;
    }
}
