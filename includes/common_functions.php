<?php
    
    $rules = array();
    require("includes/RuleDefaults.php");
    function in_arrayi($needle, $haystack) {
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }
    
    function handle_error($status,$message){
        global $ns;
        $ns->tablerender(($status >= 400 ? "Error":"Message"),$message);
        if($status >= 400){
            require_once(FOOTERF);
            die();
        }
    }
    /**
     * Returns an interger type rule
     * 
     * @param string $category Rule category
     * @param String $rule    Rule Name
     * 
     * @return int    Rule Value
     */
    function RuleI($category,$rule){
        global $rules;
        if(array_key_exists($category,$rules) && array_key_exists($rule,$rules[$rule])){
            return intval($rules[$category][$rule]);
        }else{
            //get the $eqSql var
            require_once("EQDb.php");
            $eqSql = connect();
                //$eqSql = connect();
            $RuleName = $category.":".$rule;
            if(!$eqSql->eqdb_Select("rule_values","*","ruleset_id = 1 AND rule_name like '$RuleName'")){
                //rule does not exist.
                global $RuleDefaults;
                if(!array_key_exists($RuleName,$RuleDefaults)){
                    handle_error(300,"Rule: $RuleName not found...");
                    return;
                }else{
                    return $RuleDefaults[$RuleName];
                }
            }else{
                $row = $eqSql->eqdb_Fetch();
                $rules[$category][$rule] = intval($row['rule_value']);
                return intval($row['rule_value']);
            }
        }
    }
?>