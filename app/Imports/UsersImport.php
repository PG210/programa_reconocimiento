<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithLimit; // para limitar las filas a importar
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithLimit, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $limit;
    private $count = 0;
    private $duplicatedEmails = [];
    private $importedEmails = []; 

    public function __construct($limit)
    {
        $this->limit = $limit;
    }

    public function model(array $row)
    {
        if ($this->count >= $this->limit) {
            
            return null; // Ya alcanzamos el límite
        }

        if (empty($row['name']) || empty($row['apellido']) || empty($row['direccion']) || 
            empty($row['telefono']) || empty($row['fecna']) || empty($row['fecingreso']) ||
            empty($row['id_rol']) || empty($row['id_cargo']) || empty($row['email']) || 
            empty($row['password'])) {
            throw new \Exception('Revisa el archivo: hay datos vacíos.');
        }

        if (User::where('email', $row['email'])->exists()) {
            $this->duplicatedEmails[] = $row['email'];
            return null; // ya existe, no se cuenta
        }

        $this->count++;
        $this->importedEmails[] = $row['email']; 

        return new User([
            'name' => $row['name'],
            'apellido' => $row['apellido'],
            'direccion' => $row['direccion'],
            'telefono' => $row['telefono'],
            'fecna' => Carbon::parse($row['fecna'])->format('Y-m-d'),
            'fecingreso' => Carbon::parse($row['fecingreso'])->format('Y-m-d'),
            'id_rol' => $row['id_rol'],
            'id_cargo' => $row['id_cargo'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
            'id_estado' => 1,
            'imagen' => 'perfil_no_borrar.jpeg',
        ]);

    }

    public function limit(): int
    {
        return 10000; /*importar hasta 10000 usuarios */
    }

    public function getImportedCount(): int
    {
        return $this->count;
    }

    public function getDuplicatedEmails(): array
    {
        return $this->duplicatedEmails;
    }

    public function getImportedEmails(): array
    {
        return $this->importedEmails;
    }
}
