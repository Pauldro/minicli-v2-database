<?php namespace Pauldro\Minicli\v2\Database\MeekroDB;
// ProcessWire
use Pauldro\Minicli\v2\Util\DataArray;

/**
 * Record
 * 
 * Container for Lists of Records
 */
class RecordList extends DataArray {
    public function makeBlankItem() : Record {
        return new Record();
    }
}