# php-decision-table
PHP 决策表/判决表，使用场景：用多个单个状态判断对象的综合状态

# 示例：
```php
<?php

// 定义一个用来决定下雨是否出门的决策表
class RainTable extends DecisionTableAbstract
{
    protected function buildTable()
    {
        // 条件值并不局限于0和1，可以用“===”比较的都可以
        $this->addRule(array('下雨' => 1, '有车' => 1, '有事' => 1), '出门');
        $this->addRule(array('下雨' => 0, '有车' => 0, '有事' => 0), '呆家');

        $this->addRule(array('下雨' => 1, '有车' => 1, '有事' => 0), '呆家');
        $this->addRule(array('下雨' => 1, '有车' => 0, '有事' => 0), '呆家');
        $this->addRule(array('下雨' => 1, '有车' => 0, '有事' => 1), '出门');

        $this->addRule(array('下雨' => 0, '有车' => 1, '有事' => 1), '出门');
        $this->addRule(array('下雨' => 0, '有车' => 0, '有事' => 1), '出门');
        $this->addRule(array('下雨' => 0, '有车' => 1, '有事' => 0), '呆家');
    }
}

$r = new RainTable();
echo $r->decide(array('下雨' => 1, '有车' => 1, '有事' => 1)); // 输出：出门
echo $r->decide(array('有车' => 0, '有事' => 0, '下雨' => 1)); // 输出：呆家

```