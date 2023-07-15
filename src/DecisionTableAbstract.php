<?php

namespace Nece\DecisionTable;

/**
 * 决策表抽象类
 *
 * @Author nece001@163.com
 * @DateTime 2023-06-30
 */
abstract class DecisionTableAbstract
{
    /**
     * 决策表
     *
     * @var array
     * @Author nece001@163.com
     * @DateTime 2023-06-30
     */
    protected $table = array();

    /**
     * 构造
     *
     * @Author nece001@163.com
     * @DateTime 2023-06-30
     */
    public function __construct()
    {
        $this->buildTable();
    }

    /**
     * 构建决策表
     *
     * @Author nece001@163.com
     * @DateTime 2023-06-30
     *
     * @return void
     */
    abstract protected function buildTable();

    /**
     * 添加决策条件
     *
     * @Author nece001@163.com
     * @DateTime 2023-06-30
     *
     * @param array $rule 规则条件
     * @param mixed $action 结果
     *
     * @return void
     */
    protected function addRule(array $rule, $action)
    {
        $this->table[] = array(
            'rules' => $rule,
            'action' => $action,
        );
    }

    /**
     * 执行决策
     *
     * @Author nece001@163.com
     * @DateTime 2023-06-30
     *
     * @param array $data 待决策数据
     * @param bool $no_field 给定的数据字段不存在时是否成立
     *
     * @return mixed|null 返回null表示找不出对应的决策结果
     */
    public function decide(array $data, $no_field = false)
    {
        foreach ($this->table as  $row) {
            $rules = $row['rules'];
            $action = $row['action'];

            $result = true;
            foreach ($rules as $key => $value) {
                if (isset($data[$key])) {
                    $result = $result && ($data[$key] === $value);
                } else {
                    $result = $result && $no_field;
                }
            }

            if ($result) {
                return $action;
            }
        }

        return null;
    }

    /**
     * 获取所有规则
     *
     * @Author nece001@163.com
     * @DateTime 2023-06-30
     *
     * @param mixed $action
     *
     * @return array
     */
    public function getRules($action)
    {
        $data = array();
        foreach ($this->table as $row) {
            if ($row['action'] == $action) {
                $data[] = $row;
            }
        }

        return $data;
    }

    /**
     * 获取一条规则
     *
     * @Author nece001@163.com
     * @DateTime 2023-07-15
     *
     * @param mixed $action
     *
     * @return array
     */
    public function getRule($action)
    {
        foreach ($this->table as $row) {
            if ($row['action'] == $action) {
                return $row;
            }
        }

        return array();
    }
}
