<?php

namespace App\Utils;

class InputData extends MockData
{
    protected $newInput = [
        'name' => 'Beans Beans', 'crops' => ['maize', 'beans'], 'category' => 'Pesticide',
        'description' => 'An Input of quality',
        'photo_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSDZLI0n9jEtSC-Lt8hU56X2VMXCI_sdbVF43oHZblfU7dlijak',
        'price' => [2000, 4000], 'unit' => ['Kg', 'Ton'], 'supplier' => 'east cooperative', 'quantity' => 20
    ];
    //**get input */
    public function getInputsData()
    {
        return $this->newInput;
    }
}
