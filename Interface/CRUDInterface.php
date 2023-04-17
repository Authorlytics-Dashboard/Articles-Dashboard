<?php

interface CrudInterface {
    public function create($data);
    public function show($id);
    public function showAll();
    public function update($id, $data);
    public function delete($id);
}
