<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 30/08/2017
 * Time: 15:03
 */

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class DateConditions
 * @package AppBundle\Validator
 * @Annotation
 */
class DateConditions extends Constraint
{
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy()
    {
        return DateConditionsValidator::class;
    }
}