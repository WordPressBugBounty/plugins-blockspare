<?php

defined('ABSPATH') || exit;


class Blockspare_TB_Condition_Registry
{

  /**
   * Registered conditions, keyed by slug.
   *
   * @var Blockspare_TB_Condition_Interface[]
   */
  private $conditions = array();

  /**
   * Registers a condition instance.
   *
   * @param Blockspare_TB_Condition_Interface $condition Condition to add.
   */
  public function register(Blockspare_TB_Condition_Interface $condition)
  {
    $this->conditions[$condition->get_slug()] = $condition;
  }

  /**
   * Registers the conditions this plugin ships with out of the box.
   */
  public function register_core_conditions()
  {
    $core = array(
      new Blockspare_TB_Condition_Entire_Site(),
      new Blockspare_TB_Condition_Front_Page(),
      new Blockspare_TB_Condition_Single(),
      new Blockspare_TB_Condition_Archive(),
      new Blockspare_TB_Condition_Category(),
      new Blockspare_TB_Condition_Author(),
      new Blockspare_TB_Condition_Tag(),
      new Blockspare_TB_Condition_Date_Archive(),
      new Blockspare_TB_Condition_Search(),
      new Blockspare_TB_Condition_404(),
    );

    foreach ($core as $condition) {
      $this->register($condition);
    }
  }

  /**
   * Returns all registered conditions.
   *
   * @return Blockspare_TB_Condition_Interface[]
   */
  public function all()
  {
    return $this->conditions;
  }


  public function matches($ruleset)
  {
    foreach (isset($ruleset['exclude']) ? $ruleset['exclude'] : array() as $rule) {
      if ($this->rule_matches($rule)) {
        return false;
      }
    }

    foreach (isset($ruleset['include']) ? $ruleset['include'] : array() as $rule) {
      if ($this->rule_matches($rule)) {
        return true;
      }
    }

    return false;
  }

  /**
   * Evaluates a single rule (['type' => ..., 'settings' => ...]).
   *
   * @param array $rule Single rule.
   * @return bool
   */
  private function rule_matches($rule)
  {
    $type = isset($rule['type']) ? $rule['type'] : '';

    if (! isset($this->conditions[$type])) {
      return false;
    }

    return $this->conditions[$type]->is_match(isset($rule['settings']) ? $rule['settings'] : array());
  }
}
