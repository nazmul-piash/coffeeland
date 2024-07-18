<?php
require_once 'interfaces/IDataReader.php';

class XMLRead implements IDataReader {
    private $filePath;

    public function __construct($filePath) {
        $this->filePath = $filePath;
    }

    public function readData() {
        if (!file_exists($this->filePath)) {
            die("Error: File not found");
        }

        $xml = simplexml_load_file($this->filePath);
        if (!$xml) {
            die("Error: Cannot create object");
        }

        $data = [];
        foreach ($xml->item as $item) {
            $data[] = [
                'entity_id' => (int) $item->entity_id,
                'category_name' => (string) $item->CategoryName,
                'sku' => (string) $item->sku,
                'name' => (string) $item->name,
                'shortdesc' => (string) $item->shortdesc,
                'price' => (float) $item->price,
                'link' => (string) $item->link,
                'image' => (string) $item->image,
                'brand' => (string) $item->Brand,
                'rating' => (int) $item->Rating,
                'caffeine_type' => (string) $item->CaffeineType,
                'count' => (int) $item->Count,
                'flavored' => ($item->Flavored == 'Yes') ? 1 : 0,
                'seasonal' => ($item->Seasonal == 'Yes') ? 1 : 0,
                'instock' => ($item->Instock == 'Yes') ? 1 : 0,
                'facebook' => ($item->Facebook == '1') ? 1 : 0,
                'iskcup' => ($item->IsKCup == '1') ? 1 : 0,
            ];
        }

        return $data;
    }
}
