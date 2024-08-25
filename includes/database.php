<!-- <?php 
//  if(defined('_INCODE')) die('Access deined');

// ?> 
<div>
    <p> ?php>echo $exception->getMessage(); ?></p>
    <p> ?php  echo $exception->getFile(); ?>
    <p> ?php  echo $exception->getLine(); ?>
</div> -->

<?php
// Kiểm tra hằng số bảo mật _INCODE
if (!defined('_INCODE')) die('Access Denied...');

function query($sql, $data=[]){
    global $conn;
    $query=false;
    try{
        $statement=$conn->prepare(($sql));
        if(empty($data)){
            $query=$statement->execute();
        }
        else{
            $query=$statement->execute($data);
        }
    }
    catch(Exception $exception){
        require_once 'module/error/database.php';
        die(); // Dừng thực thi nếu có lỗi
    }
    return $query;
}
function insert($table, $dataInsert) {
    $keyArr = array_keys($dataInsert);
    $fieldStr = implode(', ', $keyArr);
    $valueStr = ':' . implode(', :', $keyArr);

    $sql = 'INSERT INTO ' . $table . ' (' . $fieldStr . ') VALUES (' . $valueStr . ')';

    return query($sql, $dataInsert);
}

function update($table, $dataUpdate, $condition = '') {
    $updateStr = '';
    foreach ($dataUpdate as $key => $value) {
        $updateStr .= $key . '=:' . $key . ', ';
    }

    $updateStr = rtrim($updateStr, ', ');

    if (!empty($condition)) {
        $sql = 'UPDATE ' . $table . ' SET ' . $updateStr . ' WHERE ' . $condition;
    } else {
        $sql = 'UPDATE ' . $table . ' SET ' . $updateStr;
    }

    return query($sql, $dataUpdate);
}

function delete($table, $condition = '') {
    if (!empty($condition)) {
        $sql = "DELETE FROM $table WHERE $condition";
    } else {
        $sql = "DELETE FROM $table";
    }

    return query($sql);
}

// Lấy dữ liệu từ câu lệnh SQL
function getRaw($sql) {
    $statement = query($sql, [], true);
    if (is_object($statement)) {
        $dataFetch = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $dataFetch;
    }

    return false;
}
// Lấy dữ liệu từ câu lệnh SQL - Lấy 1 bản ghi
function firstRaw($sql) {
    $statement = query($sql, [], true);
    if (is_object($statement)) {
        $dataFetch = $statement->fetch(PDO::FETCH_ASSOC);
        return $dataFetch;
    }

    return false;
}

function get($table, $field = '*', $condition = '') {
    $sql = 'SELECT ' . $field . ' FROM ' . $table;
    if (!empty($condition)) {
        $sql .= ' WHERE ' . $condition;
    }

    return getRaw($sql);
}

function first($table, $field = '*', $condition = '') {
    $sql = 'SELECT ' . $field . ' FROM ' . $table;
    if (!empty($condition)) {
        $sql .= ' WHERE ' . $condition;
    }

    return firstRaw($sql);
}
