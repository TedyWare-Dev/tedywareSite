<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use function PHPUnit\Framework\assertCount;

class UserEntityTest extends KernelTestCase
{
    private const EMAIL_CONTRAINT_MESSAGE = 'L\'email \"dylan@gmail\" n\'est pas disponible.';

    private const NOT_BLANK_CONSTRAINT_MESSAGE = 'Veuillez saisir un email.';

    private const INVALID_EMAIL_VALUE = 'dylan@gmail';

    private const VALID_EMAIL_VALUE = 'dylan.weisse@hotmail.com';

    private const PASSWORD_REGEX_CONSTRAIN_MESSSAGE = 'Le message doit comporter au moins 8 caractère dont: 1 minuscule, 1 majuscule, 1 chiffre et 1 caractère spécial.';

    private const VALID_PASSWORD_VALUE = 'Maurgane690_';

    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->validator = $kernel->getContainer()->get('validator');
    }

    public function testUserEntityIsValid(): void
    {
        $user = new User();

        $user
            ->setEmail(self::VALID_EMAIL_VALUE)
            ->setPassword(self::VALID_PASSWORD_VALUE);

        $this->getValidationErrors($user, 0);

    }

    public function testUserEntityIsInvalidBecauseNoMailEntered(): void
    {
        $user = new User();

        $user->setPassword(self::VALID_PASSWORD_VALUE);

        $errors = $this->getValidationErrors($user, 1);

        $this->assertEquals(self::NOT_BLANK_CONSTRAINT_MESSAGE, $errors[0]->getMessage());

    }

    private function getValidationErrors(User $user, int $numberOfExpectedErrors): ConstraintViolationList
    {
        $errors = $this->validator->validate($user);
        $this->assertCount($numberOfExpectedErrors, $errors);

        return $errors;
    }

}
