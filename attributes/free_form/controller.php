<?php

namespace Concrete\Package\AttributeFreeForm\Attribute\FreeForm;

use Database,
    View,
    \Concrete\Core\Attribute\Controller as AttributeTypeController;

class Controller extends AttributeTypeController
{
    public $helpers = ['form'];

    public function getTypeValue()
    {
        $db = Database::connection();
        $ak = $this->getAttributeKey();
        $value = [];
        if (is_object($ak)) {
            $value = $db->GetRow('SELECT formCode, viewCode FROM atFreeFormSettings WHERE akID = ?', [$ak->getAttributeKeyID()]);
        }
        return $value;
    }

    public function getValue()
    {
        $db = Database::connection();
        $rawData = $db->GetOne('SELECT data FROM atFreeForm WHERE avID = ?', [$this->getAttributeValueID()]);
        return json_decode($rawData, true);
    }

    /**
     * Shows the attribute configuration form
     */
    public function type_form()
    {
        $this->requireAsset('ace');

        $values = $this->getTypeValue();

        $this->set('viewCode', $values['viewCode']);
        $this->set('formCode', $values['formCode']);
    }

    /**
     * Saves the attribute configuration
     * @param array $data
     */
    public function saveKey($data)
    {
        $ak = $this->getAttributeKey();
        $db = Database::connection();

        $db->Replace('atFreeFormSettings', [
            'akID' => $ak->getAttributeKeyID(),
            'formCode' => $data['formCode'],
            'viewCode' => $data['viewCode'],
        ], ['akID'], true);
    }

    /**
     * Shows the value, the HTML text in the form
     */
    public function form()
    {
        $typeValues = $this->getTypeValue();

        $this->set('viewCode', $typeValues['viewCode']);
        $this->set('formCode', $typeValues['formCode']);

        $this->set('values', $this->getValue());
    }

    /**
     * Called when we're searching using an attribute.
     * @param $list
     */
    public function searchForm($list)
    {
    }

    /**
     * Called when we're saving the attribute from the frontend.
     * @param $data
     */
    public function saveForm($data)
    {
        $db = Database::connection();

        $db->Replace(
            'atFreeForm',
            [
                'avID' => $this->getAttributeValueID(),
                'data' => json_encode($data),
            ],
            'avID',
            true
        );
    }

    /**
     * Called when the attribute is edited in the composer.
     */
    public function composer()
    {
        $this->form();
    }

    public function deleteKey()
    {
        $db = Database::connection();
        $arr = $this->attributeKey->getAttributeValueIDList();
        foreach ($arr as $id) {
            $db->Execute('DELETE FROM aFreeForm WHERE avID = ?', [$id]);
        }
        $db->Execute('delete from aFreeFormSettings where akID = ?', array($this->attributeKey->getAttributeKeyID()));
    }

    public function deleteValue()
    {
        $db = Database::connection();
        $db->Execute('DELETE FROM aFreeForm WHERE avID = ?', [$this->getAttributeValueID()]);
    }

}