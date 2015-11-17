<?php
class GuestsService {
    
    public static function listGuests() {
        $db = ConnectionGuest::getDB();
        $tasks = array();
        
        foreach($db->guests() as $guest) {
           $guests[] = array (
               'id' => $guest['id'],
               'name' => $guest['name'],
               'email' => $guest['email']
           ); 
        }
        
        return $guests;
    }
    
    public static function getGuest($guests) {
        $db = ConnectionGuest::getDB();
        return $db->guests;
    }
    
    public static function add($newguest) {
        $db = ConnectionGuest::getDB();
        $guest = $db->guests->insert($newguest);
        return $guest;
    }
    
    
    public static function delete($id) {
        $db = ConnectionGuest::getDB();
        $guest = $db->guests[$id];
        if($guest) {
            $guest->delete();
            return true;
        }
        return false;
    }
    
    public static function delete($guests) {
        $db = ConnectionGuest::getDB();
        $guest = $db->guests;
        if($guest) {
            $guest->delete();
            return true;
        }
        return false;
    }
}
?>