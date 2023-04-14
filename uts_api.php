<?php
require_once "config.php";
$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
   case 'GET':
         if(!empty($_GET["nim"]))
         {
            $nim=($_GET["nim"]);
            get_nilai($nim);
         }
         else
         {
            get_nilaia();
         }
         break;
   case 'POST':
         if(!empty($_GET["nim"]))
         {
            $nim=($_GET["nim"]);
            $km=($_GET["kode_mk"]);
            update_nilai($nim, $km);
         }
         else
         {
            insert_nilai();
         }     
         break; 
   case 'DELETE':
            $nim=($_GET["nim"]);
            $km=($_GET["kode_mk"]);            
            
            delete_nilai($nim, $km);
            break;
   default:
      // Invalid Request Method
         header("HTTP/1.0 405 Method Not Allowed");
         break;
      break;
 }



   function get_nilaia()
   {
      global $mysqli;
      $query="SELECT `mahasiswa`.`nim`, `mahasiswa`.`nama`, `mahasiswa`.`alamat`, `matakuliah`.`kode_mk`, `matakuliah`.`nama_mk`, `matakuliah`.`sks`, `perkuliahan`.`nilai`
      FROM `mahasiswa`
          , `matakuliah` 
          LEFT JOIN `perkuliahan` ON `perkuliahan`.`kode_mk` = `matakuliah`.`kode_mk`
          WHERE perkuliahan.nim = mahasiswa.nim
          ORDER BY mahasiswa.nim, matakuliah.kode_mk;";
      $data=array();
      $result=$mysqli->query($query);
      while($row=mysqli_fetch_object($result))
      {
         $data[]=$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Get List nilai Successfully.',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
   }
 
   function get_nilai($nim)
   {
      global $mysqli;
      $query="SELECT `mahasiswa`.`nim`, `mahasiswa`.`nama`, `mahasiswa`.`alamat`, `matakuliah`.`kode_mk`, `matakuliah`.`nama_mk`, `matakuliah`.`sks`, `perkuliahan`.`nilai`
      FROM `mahasiswa`
          , `matakuliah` 
          LEFT JOIN `perkuliahan` ON `perkuliahan`.`kode_mk` = `matakuliah`.`kode_mk`
          WHERE perkuliahan.nim = mahasiswa.nim and mahasiswa.nim ="."$nim"."
          ORDER BY mahasiswa.nim, matakuliah.kode_mk;";

      $data=array();
      $result=$mysqli->query($query);
      while($row=mysqli_fetch_object($result))
      {
         $data[]=$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Get nilai Successfully.',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
        
   }
 
   function insert_nilai()
      {
         global $mysqli;
         if(!empty($_POST["nilai"])){
            $data=$_POST;
         }else{
            $data = json_decode(file_get_contents('php://input'), true);
         }

         $arrcheckpost = array('nim' => '', 'kode_mk' =>  '','nilai' => '');
         $hitung = count(array_intersect_key($data, $arrcheckpost));
         if($hitung == count($arrcheckpost)){
          
            //    $result = mysqli_query($mysqli, "INSERT INTO mahasiswa SET
            //    nama = '$data[nama]',
            //    alamat = '$data[alamat]'");
               
               $result = mysqli_query($mysqli, "INSERT INTO `perkuliahan` 
               (`id_perkuliahan`, `nim`, `kode_mk`, `nilai`) 
               VALUES (NULL, '$data[nim]', '$data[kode_mk]', '$data[nilai]')");              



               if($result)
               {
                  $response=array(
                     'status' => 1,
                     'message' =>'nilai Added Successfully.'
                  );
               }
               else
               {
                  $response=array(
                     'status' => 0,
                     'message' =>'nilai Addition Failed.'
                  );
               }
         }else{
            $response=array(
                     'status' => 0,
                     'message' =>'Parameter Do Not Match'
                  );
         }
         header('Content-Type: application/json');
         echo json_encode($response);
      }
 
   function update_nilai($nim, $km)
      {
         global $mysqli;
         if(!empty($_POST["nilai"])){
            $data=$_POST;
         }else{
            $data = json_decode(file_get_contents('php://input'), true);
         }

         $arrcheckpost = array('nim' => '', 'kode_mk' =>  '','nilai' => '');
         $hitung = count(array_intersect_key($data, $arrcheckpost));
         if($hitung == count($arrcheckpost)){
          
            //   $result = mysqli_query($mysqli, "UPDATE mahasiswa SET
            //   nama = '$data[nama]',
            //   alamat = '$data[alamat]'
            //   WHERE id_mhs='$id'");


              $result = mysqli_query($mysqli, "UPDATE `perkuliahan` 
              SET `nilai` = '$data[nilai]'
              WHERE `perkuliahan`.`nim` ="."$nim"." and perkuliahan.kode_mk ="."$km");
          
            if($result)
            {
               $response=array(
                  'status' => 1,
                  'message' =>'nilai Updated Successfully.'
               );
            }
            else
            {
               $response=array(
                  'status' => 0,
                  'message' =>'nilai Updation Failed.'
               );
            }
         }else{
            $response=array(
                     'status' => 0,
                     'message' =>'Parameter Do Not Match'
                  );
         }
         header('Content-Type: application/json');
         echo json_encode($response);
      }
 


   function delete_nilai($nim,$km)
   {
      global $mysqli;
      // $query="DELETE FROM perkuliahan  WHERE `perkuliahan`.`nim=`"."$nim"." and `perkuliahan`.`kode_mk`="."$km";
      $query = "DELETE FROM perkuliahan WHERE `perkuliahan`.`nim` ="."$nim"." and perkuliahan.kode_mk ="."$km" ;

      if(mysqli_query($mysqli, $query))
      {
         $response=array(  
            'status' => 1,
            'message' =>'nilai Deleted Successfully.'
         );
      }
      else
      {
         $response=array(
            'status' => 0,
            'message' =>'nilai Deletion Failed.'
         );
      }
      header('Content-Type: application/json');
      echo json_encode($response);
   }

 
?> 
