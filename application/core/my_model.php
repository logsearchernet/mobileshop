<?php

class MY_Model extends CI_Model {
    const DB_TABLE = 'abstract';
    const DB_TABLE_PK = 'abstract';
    
    /**
     * Create record.
     */
    private function insert() {
        $this->db->insert($this::DB_TABLE, $this);
        $this->{$this::DB_TABLE_PK} = $this->db->insert_id();
    }
    
    /**
     * Update record.
     */
    private function update() {
        //$this->db->update($this::DB_TABLE, $this, $this::DB_TABLE_PK);
        $this->db->update($this::DB_TABLE, $this, array($this::DB_TABLE_PK => $this->{$this::DB_TABLE_PK}));  
    }
    
    /**
     * Populate from an array or standard class.
     * @param mixed $row
     */
    public function populate($row) {
        foreach ($row as $key => $value) {
            $this->$key = $value;
        }
    }
    
    /**
     * Load from the database.
     * @param int $id
     */
    public function load($id) {
        $query = $this->db->get_where($this::DB_TABLE, array(
            $this::DB_TABLE_PK => $id,
        ));
        $this->populate($query->row());
    }
    
    /**
     * Delete the current record.
     */
    public function delete() {
        $this->db->delete($this::DB_TABLE, array(
           $this::DB_TABLE_PK => $this->{$this::DB_TABLE_PK}, 
        ));
        unset($this->{$this::DB_TABLE_PK});
    }
    
    /**
     * Save the record.
     */
    public function save() {
        if (isset($this->{$this::DB_TABLE_PK})) {
            $this->update();
        }
        else {
            $this->insert();
        }
    }
    
    /**
     * Get an array of Models with an optional limit, offset.
     * 
     * @param int $limit Optional.
     * @param int $offset Optional; if set, requires $limit.
     * @param String $where WHERE
     * @param String $orderBy Order query, Sample:"title desc, name asc"
     * @return array Models populated by database, keyed by PK.
     */
    public function get($limit = 0, $offset = 0, $where=NULL, $orderBy=NULL) {
        if(isset($where) && !empty($where))
        {
            $this->db->where($where);
        }
        if(!empty($orderBy))
        {
            $this->db->order_by($orderBy); 
        }
        if ($limit) {
            $query = $this->db->get($this::DB_TABLE, $limit, $offset);
        }
        else {
            $query = $this->db->get($this::DB_TABLE);
        }
        $ret_val = array();
        $class = get_class($this);
        foreach ($query->result() as $row) {
            $model = new $class;
            $model->populate($row);
            $ret_val[$row->{$this::DB_TABLE_PK}] = $model;
        }
        return $ret_val;
    }
    
    public function getByWhere($where=NULL) {
        if(isset($where) && !empty($where))
        {
            $this->db->where($where);
        }
        $ret_val = array();
        $class = get_class($this);
        $query = $this->db->get($this::DB_TABLE);
        foreach ($query->result() as $row) {
            $model = new $class;
            $model->populate($row);
            $ret_val[$row->{$this::DB_TABLE_PK}] = $model;
        }
        return $ret_val;
    }
    
    public function count_by($where = NULL){
        if (isset($where) && !empty($where)){
            $this->db->where($where);
            return $this->db->count_all_results($this::DB_TABLE);
        }
        return $this->db->count_all_results($this::DB_TABLE);
    }
    
    /**
     * Get an array of Models with an optional limit, offset.
     * 
     * @param String $queryStr QUERY STRING
     * @return array Models populated by database, keyed by PK.
     */
    public function query($queryStr) {
        $query = $this->db->query($queryStr);
        $ret_val = array();
        $class = get_class($this);
        foreach ($query->result() as $row) {
            $model = new $class;
            $model->populate($row);
            $ret_val[$row->{$this::DB_TABLE_PK}] = $model;
        }
        return $ret_val;
    }
    
    public function max($col = NULL, $where = NULL) {
        $maxid = 0;
        $sql = 'SELECT MAX('.$col.') AS `maxid` FROM '.$this::DB_TABLE;
        if (isset($where) && !empty($where)){
            $sql .= ' WHERE '.$where;
        }
        $row = $this->db->query($sql)->row();
        if ($row) {
            $maxid = $row->maxid; 
        }
        return $maxid;
    }
}