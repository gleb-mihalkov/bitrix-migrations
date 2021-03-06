<?php

namespace Arrilot\BitrixMigrations\Autocreate\Handlers;

class OnBeforeIBlockPropertyAdd extends BaseHandler implements HandlerInterface
{
    /**
     * Constructor.
     *
     * @param array $params
     */
    public function __construct($params)
    {
        $this->fields = $params[0];
    }

    /**
     * Get migration name.
     *
     * @return string
     */
    public function getName()
    {
        return "auto_add_iblock_element_property_{$this->fields['CODE']}_to_ib_{$this->fields['IBLOCK_ID']}";
    }

    /**
     * Get template name.
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'auto_add_iblock_element_property';
    }

    /**
     * Get array of placeholders to replace.
     *
     * @return array
     */
    public function getReplace()
    {
        return [
            'fields'   => var_export($this->fields, true),
            'iblockId' => $this->fields['IBLOCK_ID'],
            'code'     => "'".$this->fields['CODE']."'",
        ];
    }
}
