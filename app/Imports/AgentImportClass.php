<?php

namespace App\Imports;

use App\Models\PartenerAgent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class AgentImportClass implements ToModel
{
    protected $partenerId;
    protected $hopitalId;
    protected $createdBy;

    public function __construct($partenerId, $hopitalId, $createdBy)
    {
        $this->partenerId = $partenerId;
        $this->hopitalId = $hopitalId;
        $this->createdBy = $createdBy;
    }

    public function model(array $row): ?PartenerAgent
    {
        HeadingRowFormatter::default('none');
        if ($this->isHeaderRow($row)) {
            return null;
        }

        $headers = $this->getHeaders();
        $row = array_combine($headers, $row);

        if ($this->isValidDataRow($row, $headers)) {
            return $this->createPartenerAgent($row);
        }
        return null;
    }

    protected function isHeaderRow(array $row): bool
    {
        return reset($row) === 'MATRICULE';
    }

    protected function getHeaders(): array
    {
        return [
            'MATRICULE',
            'NUM_CONVENTION',
            'NOM',
            'PRENOM',
            'SEXE',
            'ETAT_CIVIL',
            'NBRE_EFTS',
        ];
    }

    protected function isValidDataRow(array $row, array $headers): bool
    {
        return count(array_diff($headers, array_keys($row))) === 0;
    }

    protected function createPartenerAgent(array $row): PartenerAgent
    {
        return PartenerAgent::updateOrCreate(
            ['agent_matricule'         => $row['MATRICULE']],
            [
                'agent_matricule'      => $row['MATRICULE'],
                'agent_num_convention' => $row['NUM_CONVENTION'],
                'agent_nom'            => $row['NOM'],
                'agent_prenom'         => $row['PRENOM'],
                'agent_sexe'           => $row['SEXE'],
                'agent_etat_civil'     => $row['ETAT_CIVIL'],
                'agent_nbre_efts'      => $row['NBRE_EFTS'],
                'partener_id'          => $this->partenerId,
                'hopital_id'           => $this->hopitalId,
                'created_by'           => $this->createdBy,
            ]
        );
    }
}
