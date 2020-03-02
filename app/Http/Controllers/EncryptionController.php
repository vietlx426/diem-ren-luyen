<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\SinhVien;

use App\UserGroup;
use DB;
use ZipArchive;

class EncryptionController extends Controller
{
    //

   public function Encrytion()
   {
   		// $DS_User = User::where('id', '>', 100)->get();
   		// // print_r(count($DS_User));
   		// foreach ($DS_User as $key => $value) {
   		// 	$SV = SinhVien::find($value->cbgvsv_id);
   		// 	$password = bcrypt($SV->cmnd);
   		// 	$Us = User::find($value->id);
   		// 	$Us->password = $password;
   		// 	$Us->save();
   		// 	// echo $SV->cmnd . " - " . $password . "<br>";
   		// }
   	  // $password = bcrypt('371792561');
   	  // echo $password;

      $DS_SinhVien = SinhVien::where('id', '>=', 3315)->where('id', '<=', 3329)->get();
      print_r($DS_SinhVien->toArray());
      foreach ($DS_SinhVien as $key => $value) {
         $User = new User();
         $User->id = ($value->id + 100);
         $User->name = $value->hochulot . ' ' . $value->ten;
         $User->email = $value->email_agu;
         $User->password = bcrypt($value->cmnd);
         $User->cbgvsv_id = $value->id;
         $User->idloaiuser = 3;
         $User->idtrangthaiuser = 1;
         $User->save();

         $User_Group = new UserGroup();
         $User_Group->id = ($value->id + 100);
         $User_Group->idUser = $User->id;
         $User_Group->idGroup = 8;
         $User_Group->save();
      }
   }

   // TODO: Chức năng nén và xuất file + hình theo lớp
   public function TestCompression()
   {
      $zip_file_name = "DH19TH1";
      $zip = new ZipArchive();
      $zip_file = storage_path('images/upload/cardpic/'. $zip_file_name .'.zip');

      $invoice_file = 'DTH051136.jpg';

      if ($zip->open($zip_file, ZipArchive::CREATE)!==TRUE) {
         exit("cannot open <$zip_file>\n");
      }

      $zip->addFile(storage_path('images/upload/cardpic/'.$invoice_file), $invoice_file);

      echo "numfiles: " . $zip->numFiles . "\n";
      echo "status:" . $zip->status . "\n";
      $zip->close();
      return response()->download($zip_file);
   }
}
