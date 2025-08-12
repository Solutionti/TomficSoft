<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    

    public function iniciarSesion($user, $password) {
     
      $query = $this->db->table('usuarios')
             ->select('*')
             ->where('usuario', $user)
             ->orWhere('email', $user)
             ->where('estado', 'Activo')
             ->get();

        if($query) {
          $contador = 0;
          $data = [];
          foreach($query->getResult() as $value){
            $passAct = $value->password;
            if(password_verify($password, $passAct)){
              $contador ++;
              $data = $value;
            }
          }
        
          if($contador == 1) {
            return $data;
          }
          else {
            return false;
          }
        }
        else {
          return false;
        }
    }
}
