<?php

/*******************************************************/
/********************后台公共函数库**********************/
/*******************************************************/

/**
 * @param array $arr
 * @param int $pid
 * @param bool $layer
 * @param bool $third
 * @param bool $indent
 * @param int $lev
 * @return array
 */
function convert_tree($arr = [], $pid = 0, $layer = true, $third = true, $indent = true, $lev = 0)
{
    $result = [];
    foreach ($arr as $k => $v) {
        if ($v['pid'] == $pid) { //获取指定pid的数据
            $v['lev'] = $lev;

            if ($indent) {
                $v['title'] = str_repeat('&nbsp;&nbsp;', $lev * 5) . '├' . $v['title'];
            }

            if ($third || ($lev < 2 && !$third)) {
                $sub = convert_tree($arr, $v['id'], $layer, $third, $indent, $lev + 1);
                $v['hasSub'] = empty($sub) ? 0 : 1;
                if (!$layer) {
                    //无层级结构，数据前置
                    $result[] = $v;
                }
                if (!$layer) {
                    foreach ($sub as $g => $h) {
                        $result[] = $h;
                    }
                } else {
                    $v['children'] = $sub;
                }
            }
            if ($layer) {
                //有层级结构
                $result[] = $v;
            }
        }
    }
    return $result;
}

/**
 * 所有下级权限
 * @param $id
 * @param $arr
 * @param bool $onlyId
 * @return array
 */
function convert_tree_subs($id, $arr, $onlyId = true)
{
    $ret = [];
    if ($id && $arr) {
        $refer = [];
        foreach ($arr as $k => $v) {
            $refer[$v['id']] = &$arr[$k]; //创建主键的数组引用
        }

        foreach ($arr as $k => $v) {
            $pid = $v['pid'];  //获取当前分类的父级id
            if ($v['id'] == $id || $pid == $id || in_array($pid, $ret)) {
                if ($onlyId) {
                    $ret[] = $v['id'];
                } else {
                    $ret[] = $v;
                }
            }
        }
    }

    return $ret;
}
