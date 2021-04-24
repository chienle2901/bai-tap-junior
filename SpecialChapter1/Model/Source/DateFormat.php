<?php

namespace Magenest\SpecialChapter1\Model\Source;

use Magento\Framework\Stdlib\DateTime;

/**
 * Class DateFormat
 * @package Magenest\SpecialChapter1\Model\Source
 */
class DateFormat implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $options = [];
        $formats = [
            'yyyy-mm-dd' => 'Y-m-d',
            'mm/dd/yyyy' => 'm/d/Y',
            'dd/mm/yyyy' => 'd/m/Y',
            'd/m/yy' => 'j/n/y',
            'd/m/yyyy' => 'j/n/Y',
            'dd.mm.yyyy' => 'd.m.Y',
            'dd.mm.yy' => 'd.m.y',
            'd.m.yy' => 'j.n.y',
            'd.m.yyyy' => 'j.n.Y',
            'dd-mm-yy' => 'd-m-y',
            'yyyy.mm.dd' => 'Y.m.d',
            'dd-mm-yyyy' => 'd-m-Y',
            'yyyy/mm/dd' => 'Y/m/d',
            'yy/mm/dd' => 'y/m/d',
            'dd/mm/yy' => 'd/m/y',
            'mm/dd/yy' => 'm/d/y',
            'dd/mm yyyy' => 'd/m/Y',
            'yyyy mm dd' => 'Y m d'
        ];
        $options[] = ['value' => '', 'label' => __('----- Please select date format -----')];
        foreach ($formats as $key => $format) {
            $options[] = ['value' => $format, 'label' => $key . ' (' .date($format) . ')'];
        }
        return $options;
    }
}
