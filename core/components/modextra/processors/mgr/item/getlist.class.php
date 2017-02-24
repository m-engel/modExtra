<?php

class getlist extends modObjectGetListProcessor {
    public $classKey = 'modExtraItem';
    public $languageTopics = array('modExtra:default');
    public $objectType = 'modExtra.modExtraItem';

    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';

    public function prepareQueryBeforeCount(xPDOQuery $c) {
        if (($search = $this->getProperty('query', '')) != '') {
            $c->where([
                'name:LIKE'  => "%{$search}%",
            ], xPDOQuery::SQL_OR, NULL, 10);
        }
        return parent::prepareQueryBeforeCount($c);
    }
}

return 'getlist';