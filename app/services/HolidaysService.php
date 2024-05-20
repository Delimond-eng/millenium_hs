<?php
declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;

class HolidaysService {
    private $holidays;

    public function __construct()
    {
        $this->holidays = $this->loadHolidaysData();
    }


    /**
     * Load personals holidays for CD
     * @return string[]
    */
    private function loadHolidaysData(): array
    {
        // Charger les données des jours fériés (exemple)
        $holidaysData = [
            '2024-01-01' => 'Jour de l\'An',
            '2024-01-04' => 'Jour des Martyrs',
            '2024-03-08' => 'Journée Internationale de la Femme',
            '2024-04-04' => 'Jour de la Paix',
            '2024-05-01' => 'Fête du Travail',
            '2024-05-17' => 'Jour de la Libération',
            '2024-06-30' => 'Fête de l\'Indépendance',
            '2024-08-01' => 'Fête des Parents',
            '2024-12-25' => 'Noël',
        ];

        return $holidaysData;
    }

    /**
     * Check si la date est le jour de congé
     * @param $date
     * @return boolean
     */
    public function isHoliday($date): bool
    {
        $formattedDate = $date->format('Y-m-d');
        return isset($this->holidays[$formattedDate]);
    }

    /**
     * Retourne les jours fériés dans un mois
     * @param $month
     * @param $year
     * @return array
     */
    public function getHolidaysForMonth($month, $year): array
    {
        $holidays = [];
        foreach ($this->holidays as $date => $name) {
            $dateObject = Carbon::parse($date);
            if ($dateObject->month == $month && $dateObject->year == $year) {
                $holidays[] = [
                    'date' => $dateObject->format('Y-m-d'),
                    'name' => $name
                ];
            }
        }
        return $holidays;
    }

    /**
     * Compte les jours fériés dans une intervalle de deux date
     * @param $startDate
     * @param $endDate
     * @return integer
     */
    public function countHolidaysInRange($startDate, $endDate): int
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        $count = 0;
        foreach ($this->holidays as $date => $name) {
            $dateObject = Carbon::parse($date);
            if ($dateObject->between($start, $end)) {
                $count++;
            }
        }
        return $count;
    }


    /**
     * Compter les jours fériés en excluant les jours weekend
     * @param $startDate
     * @param $endDate
     * @return integer
     */
    public function countHolidaysInRangeExcludeWeekendDays($startDate, $endDate): int
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        $count = 0;
        foreach ($this->holidays as $date => $name) {
            $dateObject = Carbon::parse($date);
            // Vérifie si la date est entre les dates de début et de fin et si ce n'est pas un week-end
            if ($dateObject->between($start, $end) && !$this->isWeekend($dateObject)) {
                $count++;
            }
        }

        return $count;
    }


    /**
     * Detecter si une journée est un jour du weekend(samedi, dimanche)
     * @param $date
     * @return boolean
     */
    private function isWeekend($date): bool
    {
        return $date->isSaturday() || $date->isSunday();
    }
}
