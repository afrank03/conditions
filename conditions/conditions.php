<?php

class Badge
{
    public $id;
    public $title;
}

class Condition
{
    const IS_VALID = true;
    const IS_NOT_VALID = false;
    
    private $conditions;
    
    public function isValid()
    {
        foreach ($this->conditions as $condition) {
            if ($condition !== self::IS_VALID) {
                return self::IS_NOT_VALID;
            }
        }
        return self::IS_VALID;
    }

    public function setConditions(array $conditions)
    {
        $this->conditions = $conditions;
    }
}

interface ConditionInterface
{
    public function init(array $conditionsBag);
    public function getAwardBadge();
}

class RegistrationCondition extends Condition implements ConditionInterface
{
    private $config = [
        'userId' => self::IS_NOT_VALID
    ];

    public function __construct()
    {
        // Use constructor to inject dependencies like repositories etc.
    }

    public function init(array $conditionsBag)
    {
        $this->checkConditionsBag($conditionsBag);
        $this->setConditions($this->config);
    }

    public function getAwardBadge()
    {
        $badge = new Badge;
        $badge->id = 1;
        $badge->title = 'Super Badge';

        return $badge;
    }

    private function checkConditionsBag(array $conditionsBag)
    {
        // Here we can do complext logic and include more methods to split complexity
        foreach ($conditionsBag as $conditionName => $conditionValue) {
            if (array_key_exists($conditionName, $this->config)) {
                $this->config[$conditionName] = self::IS_VALID;
            }
        }
    }
}


$customCondition = new RegistrationCondition;
$myRandomCondidtionsBag = [
    'userId' => 123,
    'somethinsNotRelated' => 'string is this',
];

$customCondition->init($myRandomCondidtionsBag);

var_dump($customCondition->isValid());
var_dump($customCondition->getAwardBadge());