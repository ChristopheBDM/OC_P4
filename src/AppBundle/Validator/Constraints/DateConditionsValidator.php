<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 30/08/2017
 * Time: 15:10
 */

namespace AppBundle\Validator\Constraints;


use AppBundle\Service\DateValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class DateConditionsValidator extends ConstraintValidator
{
    private $dateValidator;

    public function __construct(DateValidator $dateValidator)
    {
        $this->dateValidator = $dateValidator;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if ($this->dateValidator->halfDayWarning($value->getDatereza(), $value->getBillets())) {
            $this->context->buildViolation('Un billet de type "Journée" pour le jour même ne peut pas être 
                réservé après 14H.')
                ->atPath('date_reza')
                ->addViolation();
        }

        if ($this->dateValidator->overSellForADay($value)) {
            $this->context->buildViolation('Le nombre de commande maximum est atteint pour cette date.
            Il ne peut y avoir de réservations supplémentaires')
                ->atPath('date_reza')
                ->addViolation();
        }

        if ($this->dateValidator->isNotWorkable($value->getDatereza()) || $this->dateValidator->sundayIsClose($value->getDatereza())) {
            $this->context->buildViolation('Pas de réservation possible les dimanches et jours fériés.')
                ->atPath('date_reza')
                ->addViolation();
        }

        if ($this->dateValidator->datePassed($value->getDatereza())) {
            $this->context->buildViolation('La date choisie est passée.')
                ->atPath('date_reza')
                ->addViolation();
        }
    }
}
