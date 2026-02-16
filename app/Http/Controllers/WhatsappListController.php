<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WhatsappList;
use App\Models\Event;

class WhatsappListController extends Controller
{
    /**
     * Importation des contacts via un fichier CSV
     */
    public function import(Request $request)
    {
        // 1. Validation du fichier et de l'événement
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        
        // 2. Lecture du fichier CSV
        $data = array_map('str_getcsv', file($path));

        // On retire la première ligne (les titres des colonnes)
        array_shift($data);

        $importedCount = 0;

        foreach ($data as $row) {
            // On s'assure que la ligne contient bien le nom [0] et le tel [1]
            if (isset($row[0]) && isset($row[1])) {
                $name = trim($row[0]);
                // Nettoyage du numéro : on ne garde que les chiffres
                $phone = preg_replace('/[^0-9]/', '', $row[1]);

                if (!empty($phone)) {
                    // 3. Insertion ou mise à jour (évite les doublons pour un même événement)
                    WhatsappList::updateOrCreate(
                        [
                            'phone_number' => $phone, 
                            'event_id' => $request->event_id
                        ],
                        [
                            'contact_name' => $name,
                            'frequency' => 'daily',
                            'is_active' => true,
                            'last_sent_at' => null // Nouveau contact = éligible au prochain passage du robot
                        ]
                    );
                    $importedCount++;
                }
            }
        }

        return back()->with('success', "Succès : $importedCount contacts ajoutés à la liste de relance.");
    }
}