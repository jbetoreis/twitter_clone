<?php
namespace App\Models;
use MF\Model\Model;

class Tweet extends Model{
    private $id;
    private $id_usuario;
    private $tweet;
    private $data;

    public function __get($atr){
        return $this->$atr;
    }

    public function __set($atr, $valor){
        $this->$atr = $valor;
    }

    // Salvar tweet
    public function salvar(){
        $sql = 'insert into tweets (id_usuario, tweet) VALUES(:id_usuario, :tweet)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':tweet', $this->__get('tweet'));

        $stmt->execute();

        return $this;
    }

    // Recuperar tweet

    public function recuperar_tweet(){
        $sql = 'select 
            t.id, t.id_usuario, t.tweet, DATE_FORMAT(t.data, "%d/%m/%y %H:%i") as data, u.nome 
            from 
                tweets as t
                left join usuarios as u on (t.id_usuario = u.id)
            where 
                id_usuario = :id_usuario
            order by
                t.data desc';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

?>