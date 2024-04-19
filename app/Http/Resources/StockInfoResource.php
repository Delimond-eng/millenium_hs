<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StockInfoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'produit_id' => $this->produit->id,
            'produit_code' => $this->produit->produit_code,
            'libelle' => $this->produit->produit_libelle,
            'qte_entree' => $this->qte_entree,
            'qte_sortie' => $this->qte_sortie,
        ];
    }
}
