<?php
// ================================================
    // LECTURE ET AFFICHAGE DES LIGNES DU FICHIER
    
    $handle = fopen($file, 'r');
    
    /*
    // Affichage des lignes du fichier CSV original
    echo '<table border="1">';
    $row = 0;
    if ($handle !== FALSE) {
        
        $array_file_data = array();
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            
            $num = count($data);
            
            if($row == 0){
                
                $colspan = $num+1;
                
                echo '<tr><th colspan="'.$colspan.'"><h3> '.$num.' champs trouvés</h3></th></tr><tr>';
                echo '<tr><th colspan="'.$colspan.'"><h3> '.$num.' champs à la ligne '.$row.'</h3></th></tr><tr>';
            }
            
            $row++;
            
            echo '<td>'.$row.'</td>'; // Numéro de ligne
            
            $array_file_rows = array();
            
            for ($c = 0; $c < $num; $c++) {
                
                $cell_data = preg_replace('/\r|\n/', '', $data[$c]);
                
                array_push($array_file_rows, $cell_data);
                
                echo '<td>'.utf8_encode($cell_data).'</td>';
            }
            echo '</tr>';
            
            array_push($array_file_data, $array_file_rows);
        }
        
        fclose($file);
    }
    echo '</table>';
    */
    
    // ================================================
    // ON PLACE LES VALEURS DU FICHIER CSV DANS UN TABLEAU
    
    $row = 0;
    if ($handle !== FALSE) {
        
        $array_file_data = array();
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            
            $num = count($data);
            
            $row++;
            
            $array_file_rows = array();
            
            for ($c = 0; $c < $num; $c++) {
                
                $cell_data = preg_replace('/\r|\n/', '', $data[$c]);
                
                array_push($array_file_rows, $cell_data);
            }
            
            array_push($array_file_data, $array_file_rows);
        }
        
        fclose($handle);
    }
    
    /*
    echo '<pre>';
    //print_r($array_file_data[0]);
    //print_r($array_file_data[1]);
    print_r($array_file_data);
    echo '</pre>';
    */