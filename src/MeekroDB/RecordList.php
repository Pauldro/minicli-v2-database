<?php namespace Pauldro\Minicli\v2\Database\MeekroDB;
// ProcessWire
use Pauldro\Minicli\v2\Util\DataArray;

/**
 * Record
 * Class for DatabaseTable Record
 */
class RecordList extends DataArray {
    public function makeBlankItem() {
        return new Record();
    }
}