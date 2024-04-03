<?php declare(strict_types=1);

/**
 * Field
 * 
 * This class is responsible for handling field values
 * 
 * @category Model
 * @package  Field
 * 
 */
class Field {
    private const allowed_type = [PDO::PARAM_STR, PDO::PARAM_INT];
    private $name = null;
    private $type = null;
    private $value = null;

    /**
     * Constructor
     * 
     * @param string $name
     * @param int $type
     * 
     */
    function __construct($name, $type=PDO::PARAM_STR) {
        $this->name = $name;
        if (in_array($type, $this::allowed_type, TRUE)) {
            $this->type = $type;
        }
    }

    /**
     * Get value
     * 
     * @return string|int
     * 
     */
    public function getValue(){
        return $this->value;
    }

    /**
     * Get name
     * 
     * @return string
     * 
     */
    public function getName(){
        return $this->name;
    }

    /**
     * Get type
     * 
     * @return int
     * 
     */
    public function getType(){
        return $this->type;
    }

    /**
     * Set value
     * 
     * @param string|int $value
     * 
     * @return bool
     * 
     */
    public function setValue($value) {
        if ($this->type === $this::allowed_type[0]){
            $this->value = (string) $value;
            return true;
        } else if ($this->type === $this::allowed_type[1]){
            $this->value = (int) $value;
            return true;
        } else {
            return false;
        }
    }
}

?>