<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MesPojos
 *
 * @author sylvain
 */
class MesPojos {

    private $db; // connection a ma DB
    private $tableauTable = array();
    private $TableauDeTableParColonnes = array();
    private $path;

    function __construct($db,$path) {
        try
	{

        	$this->db =  new PDO('mysql:host=localhost;dbname='.$db,'root', '');
        	$this->path =$path;
                }
	catch(Exception $e)
	{
		// En cas d'erreur, on affiche un message et on arrête tout
        	die('Erreur : '.$e->getMessage());
        
	}
        	$this->SelectTable();
        	$this->SelectColonnesParTable();
        	$this->generateurPojo();
         	$this->generateurDAO();;
    	}
    
/*----------------------------------------------------------------------*/  
/*Setter and Getter*/
    
   private function getPath() {
        return $this->path;
    }

    private function setPath($path) {
        $this->path = $path;
    }

        public function getDb() {
        return $this->db;
    }

    private function setDb($db) {
        $this->db = $db;
    }

    private function getTableauTable() {
        return $this->tableauTable;
    }

    private function setTableauTable($tableauTable) {
        $this->tableauTable = $tableauTable;
    }

   private function getTableauDeTableParColonnes() {
        return $this->TableauDeTableParColonnes;
    }

   private function setTableauDeTableParColonnes($TableauDeTableParColonnes) {
        $this->TableauDeTableParColonnes = $TableauDeTableParColonnes;
    }
    
 /* ---------------------------------------------------------------------- */
 /* Function */

    
    private function SelectTable() {

        $reponse = $this->db->query('SHOW TABLES');
        $table = $reponse->fetchALL(PDO::FETCH_ASSOC);
        $i = 0;

        foreach ($table as $key => $value) {

            foreach ($value as $key2 => $value2) {
                $this->tableauTable[$i] = $value2;
                $i++;
            }
        }
    }

   private function SelectColonnesParTable() {


        foreach ($this->tableauTable as $value) {
            $i = 0;
            $reponse = $this->db->query("SHOW COLUMNS FROM $value");
            $data = $reponse->fetchALL(PDO::FETCH_ASSOC);
            foreach ($data as $valeur) {

                $this->TableauDeTableParColonnes[$value][$i] = $valeur;
                $i++;
            }
        }
    }

    private function generateurPojo() {

        $c = $this->TableauDeTableParColonnes;
        foreach ($c as $key => $value) {
           
           // mise en place de la MAJ sur les premieres lettre de mes classes
            $key=ucfirst($key);
            // ouverture du fichier dans lequel on souhaite ecrire
             $paths = $this->path."/beans/";
             $post = $paths. $key . ".java";
             echo $post;
          if (file_exists($paths)){
            $monfichier = fopen($post, 'w+');
            fwrite($monfichier, 'package pack.beans;
import java.*; 
public class ' . $key . " {  \n");
          }else{
              
             mkdir($paths, 0777);
             $post =  $paths.$key . ".java"; 
             $monfichier = fopen($post, 'w+');
            fwrite($monfichier, 'package pack.beans;
                 import java.*;
public class ' . $key . " {  \n");
           
          }
            for ($index = 0; $index < sizeof($value); $index++) {

                $y = mb_strcut($value[$index]['Type'], 0, 3);
                if ($y == 'int') {
                    fwrite($monfichier, "    private Integer " . $value[$index]['Field'] . "; \n");
                } else if ($y == 'var') {
                    fwrite($monfichier, "    private String " . $value[$index]['Field'] . "; \n");
                } else if ($y == 'tex') {
                    fwrite($monfichier, "    private String " . $value[$index]['Field'] . "; \n");
                } else if ($y == 'dat') {
                    fwrite($monfichier, "    private Date " . $value[$index]['Field'] . "; \n");
                } else if ($y == 'big') {
                    fwrite($monfichier, "    private Date " . $value[$index]['Field'] . "; \n");
                } else if ($y == 'timestamp') {
                    fwrite($monfichier, "    private Timestamp " . $value[$index]['Field'] . "; \n");
                }
            }
            fwrite($monfichier, '   // creation du constructeur Vide 
     public ' . $key . "() { 
      
      }\n
      // Creation du constructeur Plein \n
    public  $key (");
            for ($index = 0; $index < count($value); $index++) {
                    $y = mb_strcut($value[$index]['Type'], 0, 3);
                if (count($value) != $index + 1) {
                
                     if ($y == 'int') {
                        fwrite($monfichier, "Integer " . $value[$index]['Field']." ,");
                       
                    } else if ($y == 'var') {
                        fwrite($monfichier, "String " . $value[$index]['Field']." ,");
                        
                    } else if ($y == 'tex') {
                        fwrite($monfichier, "String " . $value[$index]['Field']." ,");
                         
                    } else if ($y == 'dat') {
                        fwrite($monfichier, "Date " . $value[$index]['Field']." ,");
                        
                    } else if ($y == 'big') {
                        fwrite($monfichier, "Big " . $value[$index]['Field']." ,");
                        
                    
                    } else if ($y == 'timestamp') {
                        fwrite($monfichier, "Timestamp " . $value[$index]['Field']." ,");
                         
                    }
                   
                           
                } else {
                    if ($y == 'int') {
                        fwrite($monfichier, " Integer " . $value[$index]['Field']);
                    } else if ($y == 'var') {
                        fwrite($monfichier, " String " . $value[$index]['Field']);
                    } else if ($y == 'tex') {
                        fwrite($monfichier, " String " . $value[$index]['Field']);
                    } else if ($y == 'dat') {
                        fwrite($monfichier, " Date " . $value[$index]['Field']);
                    }else if ($y == 'big') {
                        fwrite($monfichier, " Big " . $value[$index]['Field']);            
                    }else if ($y == 'timestamp') {
                        fwrite($monfichier, " Timestamp " . $value[$index]['Field']);
                    }
                }
            }
            fwrite($monfichier, ") { \n");

            for ($index = 0; $index < sizeof($value); $index++) {

                $y = mb_strcut($value[$index]['Type'], 0, 3);
                if ($y == 'int') {
                    fwrite($monfichier, "        this." . $value[$index]['Field'] . " = " . $value[$index]['Field'] . ";\n");
                } else if ($y == 'var') {
                    fwrite($monfichier, "        this." . $value[$index]['Field'] . " = " . $value[$index]['Field'] . ";  \n");
                } else if ($y == 'tex') {
                    fwrite($monfichier, "        this." . $value[$index]['Field'] . " = " . $value[$index]['Field'] . "; \n");
                } else if ($y == 'dat') {
                    fwrite($monfichier, "        this." . $value[$index]['Field'] . " = " . $value[$index]['Field'] . "; \n");
                }else if ($y == 'big') {
                    fwrite($monfichier, "        this." . $value[$index]['Field'] . " = " . $value[$index]['Field'] . "; \n");
                }else if ($y == 'timestamp') {
                    fwrite($monfichier, "        this." . $value[$index]['Field'] . " = " . $value[$index]['Field'] . "; \n");
            }
            }
            fwrite($monfichier, " } 
        
         // Creation des Getter et Setter 
        \n");
            for ($index = 0; $index < sizeof($value); $index++) {

                $y = mb_strcut($value[$index]['Type'], 0, 3);
                if ($y == 'int') {
                    fwrite($monfichier, "    public Integer get" .  ucfirst($value[$index]['Field']) . "() {\n          return  "
                            . $value[$index]['Field'] ." ;\n}  \n");
                                fwrite($monfichier,"    public Integer set" .  ucfirst($value[$index]['Field']) . "(Integer " . $value[$index]['Field'] . " ){ \n 
        this." . $value[$index]['Field'] . " = " . $value[$index]['Field'] . ";
        return  " . $value[$index]['Field'] . ";\n}  \n");
                } else if ($y == 'var') {
                    fwrite($monfichier, "    public String get" . ucfirst($value[$index]['Field']) . "(){ \n          return  "
                            . $value[$index]['Field'] . ";\n}  \n  ");
            fwrite($monfichier,"    public String set" . ucfirst($value[$index]['Field']) . "(String " . $value[$index]['Field'] . " ){ \n  
        this." . $value[$index]['Field'] . "=" . $value[$index]['Field'] . ";
        return  " . $value[$index]['Field'] . ";\n}  \n");
                } else if ($y == 'tex') {
                    fwrite($monfichier, "    public String get" . ucfirst($value[$index]['Field']) . "(){ \n          return  "
                            . $value[$index]['Field'] . ";\n} \n");
             fwrite($monfichier,"    public String set" . ucfirst($value[$index]['Field']) . "(String " . $value[$index]['Field'] . " ){\n  
        this." . $value[$index]['Field'] . "=" . $value[$index]['Field'] . ";
        return  " . $value[$index]['Field'] . ";\n}  \n");
                } else if ($y == 'dat') {
                    fwrite($monfichier, "    public Date get" . ucfirst($value[$index]['Field']) . "(){\n          return  "
                            . $value[$index]['Field'] . ";\n}  \n"); 
                        fwrite($monfichier,"    public Date set" . ucfirst($value[$index]['Field']) . "(Date " . $value[$index]['Field'] . " ){\n  
                 this." . $value[$index]['Field'] . "=" . $value[$index]['Field'] . ";
                 return  " . $value[$index]['Field'] . ";\n}  \n");
                }else if ($y == 'big') {
                    fwrite($monfichier, "    public Big get" . ucfirst($value[$index]['Field']) . "(){\n          return  "
                            . $value[$index]['Field'] . ";\n}  \n"); 
                        fwrite($monfichier,"    public Big set" . ucfirst($value[$index]['Field']) . "(Big " . $value[$index]['Field'] . " ){\n  
                 this." . $value[$index]['Field'] . "=" . $value[$index]['Field'] . ";
                 return  " . $value[$index]['Field'] . ";\n}  \n");
                }else if ($y == 'timestamp') {
                    fwrite($monfichier, "    public Timestamp get" . ucfirst($value[$index]['Field']) . "(){\n          return  "
                            . $value[$index]['Field'] . ";\n}  \n"); 
                        fwrite($monfichier,"    public Timestamp set" . ucfirst($value[$index]['Field']) . "(Timestamp " . $value[$index]['Field'] . " ){\n  
                 this." . $value[$index]['Field'] . "=" . $value[$index]['Field'] . ";
                 return  " . $value[$index]['Field'] . ";\n}  \n");
                }
                
            }
            fwrite($monfichier, " }");
            fclose($monfichier);
        }
        
    }



    private function generateurDAO() {
         $c = $this->TableauDeTableParColonnes;
           foreach ($c as $key => $value) {
            
           // mise en place de la MAJ sur les premieres lettre de mes classes
            $key=ucfirst($key);
            $key2=  lcfirst($key);
            // ouverture du fichier dans lequel on souhaite ecrire
             $paths = $this->path."/daos/";
             $post = $paths. $key . "DAO.java";
          if (file_exists($paths)){
               
            $monfichier = fopen($post, 'w+');
            fwrite($monfichier, '
package pack.daos;
import fr.pb.connexion.ConnexionMySQL;
import java.*;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;
import java.util.List;
import pack.beans;

public class ' . $key . "DAO {  \n");
          }else{
             mkdir($paths, 0777);
             $monfichier = fopen($post, 'w+');
            fwrite($monfichier, 'package pack.daos;
import fr.pb.connexion.ConnexionMySQL;
import java.*;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;
import java.util.List;
import pack.beans;
                
    public class ' . $key . "DAO {  \n");
          }
           fwrite($monfichier,"// Creation des Attributs 
    private Connection co;
    private ResultSet lrs;
    private PreparedStatement pState;
                   
    // Creation du constructeur Vide
    public " . $key . "DAO() { 
      this.co=ConnexionMySQL.getCN(\"127.0.0.1\", \"3306\", \"root\", \"\", \"$key\");
        }
    // Creation du constructeur Plein
    public ". $key ."DAO(Connection co) {
        this.co = co;
    }
    
    public Connection getCo() {
        return co;
    }

    public void setCo(Connection co) {
        this.co = co;
    }

    public ResultSet getlrs() {
        return lrs;
    }

    public void setlrs(ResultSet lrs) {
        this.lrs = lrs;
    }

    public PreparedStatement getpState() {
        return pState;
    }

    public void setpState(PreparedStatement pState) {
        this.pState = pState;
    }

    //----------------------------------------------
    // Fonction de selection de tout la tables
     public List<$key> selectAll() {
          List<$key> list".$key2." = new ArrayList<$key>();
        try {
           pState = co.prepareStatement(\"SELECT * FROM ".$key2."\");
           lrs = pState.executeQuery();

           while (lrs.next()) {
             $key ".$key2." = new $key();
                ");
            for ($index = 0; $index < sizeof($value); $index++) {
                    $b= ucfirst($value[$index]['Field']);
                $y = mb_strcut($value[$index]['Type'], 0, 3);
                $index2= 1+$index;
                if ($y == 'int') {
                    fwrite($monfichier, "                $key2.set$b(lrs.getInt($index2));\n");
                } else if ($y == 'var') {
                    fwrite($monfichier, "                $key2.set$b(lrs.getString($index2));\n");
                } else if ($y == 'tex') {
                    fwrite($monfichier, "                $key2.set$b(lrs.getString($index2));\n");
                } else if ($y == 'dat') {
                    fwrite($monfichier, "                $key2.set$b(lrs.getDate($index2));\n");
                }else if ($y == 'big') {
                    fwrite($monfichier, "                $key2.set$b(lrs.getString($index2));\n");
                }else if ($y == 'timestamp') {
                    fwrite($monfichier, "                $key2.set$b(lrs.getTimestamp($index2));\n");
            }
            }
            fwrite($monfichier, " }
        } catch (Exception e) {
        }

        return list".$key2.";
    }
    //-------------------------------------------------------------------
            // Fonction de selection d'un Id sur la table
     public List<$key> selectOne(Integer asInteger) {
         List<$key> list".$key2." = new ArrayList<$key>();
        try {
           pState = co.prepareStatement(\"SELECT * FROM ".$key2." WHERE ".$value[0]['Field']." =  asInteger \");
           pState.setInt(1, asInteger);
           lrs = pState.executeQuery();

     
           while (lrs.next()) {
             $key ".$key2." = new $key();
                ");
            for ($index = 0; $index < sizeof($value); $index++) {
                    $b= ucfirst($value[$index]['Field']);
                $y = mb_strcut($value[$index]['Type'], 0, 3);
                $index2= 1+$index;
                if ($y == 'int') {
                    fwrite($monfichier, "                $key2.set$b(lrs.getInt($index2));\n");
                } else if ($y == 'var') {
                    fwrite($monfichier, "                $key2.set$b(lrs.getString($index2));\n");
                } else if ($y == 'tex') {
                    fwrite($monfichier, "                $key2.set$b(lrs.getString($index2));\n");
                } else if ($y == 'dat') {
                    fwrite($monfichier, "                $key2.set$b(lrs.getDate($index2));\n");
                }else if ($y == 'big') {
                    fwrite($monfichier, "        $key2.set$b(lrs.getString($index2));\n");
                }else if ($y == 'timestamp') {
                    fwrite($monfichier, "        $key2.set$b(lrs.getTimestamp($index2));\n");
            }
            }
            fwrite($monfichier, "            }
        } catch (Exception e) {
        }

        return list".$key2.";
    }
 //-------------------------------------------------------------------
            // Fonction de Insert d'un Id sur la table
     public void  Insert$key (Integer asInteger) {
         
        try {
           pState = co.prepareStatement(\" INSERT INTO ".$key2." ("); 
                  for ($index = 1; $index < sizeof($value); $index++) {
                $b = ucfirst($value[$index]['Field']);
                $y = mb_strcut($value[$index]['Type'], 0, 3);
                if (count($value) != $index + 1) {
                    if ($y == 'int') {
                        fwrite($monfichier, " (" . $value[$index]['Field'] . "=as" . $value[$index]['Field'] . "),");
                    } else if ($y == 'var') {
                        fwrite($monfichier, " " . $value[$index]['Field'] . "=as" . $value[$index]['Field'] . "),");
                    } else if ($y == 'tex') {
                        fwrite($monfichier, " " . $value[$index]['Field'] . "=as" . $value[$index]['Field'] . "),");
                    } else if ($y == 'dat') {
                        fwrite($monfichier, " " . $value[$index]['Field'] . "=as" . $value[$index]['Field'] . "),");
                    } else if ($y == 'big') {
                        fwrite($monfichier, " " . $value[$index]['Field'] . "=as" . $value[$index]['Field'] . "),");
                    } else if ($y == 'timestamp') {
                        fwrite($monfichier, " " . $value[$index]['Field'] . "=as" . $value[$index]['Field'] . "),");
                    }
                } else {
                    if ($y == 'int') {
                        fwrite($monfichier, "" . $value[$index]['Field'] . "=as" . $value[$index]['Field'] . ")");
                    } else if ($y == 'var') {
                        fwrite($monfichier, "" . $value[$index]['Field'] . "=as" . $value[$index]['Field'] . ")");
                    } else if ($y == 'tex') {
                        fwrite($monfichier, "" . $value[$index]['Field'] . "=as" . $value[$index]['Field'] . ")");
                    } else if ($y == 'dat') {
                        fwrite($monfichier, "" . $value[$index]['Field'] . "=as" . $value[$index]['Field'] . ")");
                    } else if ($y == 'big') {
                        fwrite($monfichier, "" . $value[$index]['Field'] . "=as" . $value[$index]['Field'] . ")");
                    } else if ($y == 'timestamp') {
                        fwrite($monfichier, "" . $value[$index]['Field'] . "=as" . $value[$index]['Field'] . ")");
                    }
                }echo $value[$index]['Type'] . "<br/>";
            }
            fwrite($monfichier, "WHERE (" . $value[0]['Field'] . "=asInteger)\");");


            for ($index = 1; $index < sizeof($value); $index++) {
                $b = ucfirst($value[$index]['Field']);
                $y = mb_strcut($value[$index]['Type'], 0, 3);
                $index2 = 1 + $index;
                if ($y == 'int') {
                    fwrite($monfichier, "                pState.setInt($index2,as" . $value[$index]['Field'] . ");\n");
                } else if ($y == 'var') {
                    fwrite($monfichier, "                pState.setString($index2,as" . $value[$index]['Field'] . ");\n");
                } else if ($y == 'tex') {
                    fwrite($monfichier, "                pState.setString($index2,as" . $value[$index]['Field'] . ");\n");
                } else if ($y == 'dat') {
                    fwrite($monfichier, "                pState.setDate($index2,as" . $value[$index]['Field'] . ");\n");
                } else if ($y == 'big') {
                    fwrite($monfichier, "                pState.setBig($index2,as" . $value[$index]['Field'] . ");\n");
                } else if ($y == 'timestamp') {
                    fwrite($monfichier, "                pState.setTimestamp($index2,as" . $value[$index]['Field'] . ");\n");
                }
            }
            fwrite($monfichier, "pState.executeUpdate();
            
        } catch (Exception e) {
        }       
    }");
                    
           fwrite($monfichier, " 
               //-------------------------------------------------------------------
            // Fonction de Update d'un Id sur la table
     public void Update$key (Integer asInteger) {
         
        try {
           pState = co.prepareStatement(\" UPDATE $key2 SET   ("); 
            for ($index = 0; $index < sizeof($value); $index++) {
                    $b= ucfirst($value[$index]['Field']);
                $y = mb_strcut($value[$index]['Type'], 0, 3);
                if(count($value) != $index + 1){
                if ($y == 'int') {
                    fwrite($monfichier, " (". $value[$index]['Field']. "=as". $value[$index]['Field']."),");
                } else if ($y == 'var') {
                    fwrite($monfichier, " ". $value[$index]['Field']. "=as". $value[$index]['Field']."),");
                } else if ($y == 'tex') {
                    fwrite($monfichier, " ". $value[$index]['Field']. "=as". $value[$index]['Field']."),");
                } else if ($y == 'dat') {
                    fwrite($monfichier, " ". $value[$index]['Field']. "=as". $value[$index]['Field']."),");
                }else if ($y == 'big') {
                    fwrite($monfichier, " ". $value[$index]['Field']. "=as". $value[$index]['Field']."),");
                }else if ($y == 'timestamp') {
                    fwrite($monfichier, " ". $value[$index]['Field']. "=as". $value[$index]['Field']."),");
            }
                }else{
                if ($y == 'int') {
                    fwrite($monfichier, "". $value[$index]['Field']. "=as". $value[$index]['Field'].")");
                } else if ($y == 'var') {
                    fwrite($monfichier, "". $value[$index]['Field']. "=as". $value[$index]['Field'].")");
                } else if ($y == 'tex') {
                    fwrite($monfichier, "". $value[$index]['Field']. "=as". $value[$index]['Field'].")");
                } else if ($y == 'dat') {
                    fwrite($monfichier, "". $value[$index]['Field']. "=as". $value[$index]['Field'].")");
                }else if ($y == 'big') {
                    fwrite($monfichier, "". $value[$index]['Field']. "=as". $value[$index]['Field'].")");
                }else if ($y == 'timestamp') {
                    fwrite($monfichier, "". $value[$index]['Field']. "=as". $value[$index]['Field'].")");
            }   
            }echo $value[$index]['Type']."<br/>";
            
           }
           fwrite($monfichier, "WHERE (".$value[0]['Field']."=asInteger)\");");
           
          
         for ($index = 0; $index < sizeof($value); $index++) {
                    $b= ucfirst($value[$index]['Field']);
                $y = mb_strcut($value[$index]['Type'], 0, 3);
                $index2= 1+$index;
                if ($y == 'int') {
                    fwrite($monfichier, "                pState.setInt($index2,as". $value[$index]['Field'].");\n");
                } else if ($y == 'var') {
                    fwrite($monfichier, "                pState.setString($index2,as". $value[$index]['Field'].");\n");
                } else if ($y == 'tex') {
                    fwrite($monfichier, "                pState.setString($index2,as". $value[$index]['Field'].");\n");
                } else if ($y == 'dat') {
                    fwrite($monfichier, "                pState.setDate($index2,as". $value[$index]['Field'].");\n");
                }else if ($y == 'big') {
                    fwrite($monfichier, "                pState.setBig($index2,as". $value[$index]['Field'].");\n");
            }else if ($y == 'timestamp') {
                    fwrite($monfichier, "                pState.setTimestamp($index2,as". $value[$index]['Field'].");\n");
            }
            }
            fwrite($monfichier, "pState.executeUpdate();
          
        } catch (Exception e) {
        }
}
}");
            fclose($monfichier);
           }
         
    }
        
    }
