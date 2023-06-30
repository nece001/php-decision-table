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
     * @param array $condition 条件
     * @param mixed $action 结果
     *
     * @return void
     */
    protected function addRule(array $condition, $action)
    {
        $this->table[] = array(
            'condition' => $condition,
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
            $conditions = $row['condition'];
            $action = $row['action'];

            $result = true;
            foreach ($conditions as $key => $value) {
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
     * 获取决策条件
     *
     * @Author nece001@163.com
     * @DateTime 2023-06-30
     *
     * @param mixed $action
     *
     * @return array
     */
    public function condition($action)
    {
        $data = array();
        foreach ($this->table as $row) {
            if ($row['action'] == $action) {
                $data[] = $row;
            }
        }

        return $data;
    }
}
