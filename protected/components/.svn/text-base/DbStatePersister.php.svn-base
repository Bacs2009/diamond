<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 28.08.12
 * Time: 16:21
 * To change this template use File | Settings | File Templates.
 */

class DbStatePersister extends CStatePersister {
    /**
     * @var boolean if the database table should be automatically created if it does not exist.
     * Defaults to TRUE.
     */
    public $autoCreatePersisterTable = TRUE;

    /**
     * @var string the table name, defaults to YiiPersister
     */
    public $persisterTableName = 'YiiPersister';

    /**
     * @var string the ID of the connection component, defaults to 'db'
     */
    public $connectionID = 'db';

    /**
     * @var CDbConnection the DB connection instance
     */
    private $_db;


    protected function createPersisterTable($db, $tableName) {
        $sql = "
            CREATE TABLE IF NOT EXISTS $tableName
            (
                    id int PRIMARY KEY,
                    data TEXT
            )";
        $db->createCommand($sql)->execute();
    }

    protected function getDbConnection() {
        if ($this->_db !== null)
            return $this->_db;
        else if (($id = $this->connectionID) !== null && ($this->_db = Yii::app()->getComponent($id)) instanceof CDbConnection)
            return $this->_db;
        else
            throw new CException(Yii::t('yii', 'CDbHttpSession.connectionID "{id}" is invalid. Please make sure it refers to the ID of a CDbConnection application component.', array('{id}' => $id)));
    }


    /**
     * Initializes the component.
     */
    public function init() {
        $db = $this->getDbConnection();
        $db->setActive(true);

        if ($this->autoCreatePersisterTable) {
            try {
                $this->createPersisterTable($db, $this->persisterTableName);
            }
            catch (Exception $e) {
            }
        }
        return true;
    }

    /**
     * Loads state data from persistent storage.
     * @return mixed state data. Null if no state data available.
     */
    public function load() {
        if (($content = $this->getContents()) !== false)
            return unserialize($content);
        else
            return null;
    }

    /**
     * Read the data from the table
     */
    private function getContents() {
        $sql = "
            SELECT data FROM {$this->persisterTableName}
            WHERE id=1
            ";
        $data = $this->getDbConnection()->createCommand($sql)->queryScalar();
        return $data === false ? '' : $data;

    }

    /**
     * Saves application state in persistent storage.
     * @param mixed $state state data (must be serializable).
     */
    public function save($state) {
        $data = serialize($state);
        try {
            $db = $this->getDbConnection();
            $sql = "SELECT id FROM {$this->persisterTableName} WHERE id=1";
            if ($db->createCommand($sql)->queryScalar() === false)
                $sql = "INSERT INTO {$this->persisterTableName} (id, data) VALUES (1, :data)";
            else
                $sql = "UPDATE {$this->persisterTableName} SET data=:data WHERE id=1";
            $db->createCommand($sql)->bindValue(':data', $data)->execute();
        }
        catch (Exception $e) {
            if (YII_DEBUG)
                echo $e->getMessage();
            return false;
        }
        return true;
    }
}