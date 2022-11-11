<?php


namespace App\Tests\Form\Type;


use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\Form\Test\TypeTestCase;

class ContactTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'name' => 'Jan',
            'surname' => 'Tester',
            'phone' => '+420721010203',
        ];

        $model = new Contact();

        $form = $this->factory->create(ContactType::class, $model);

        $expected = new Contact();
        $expected->setName('Jan');
        $expected->setSurname('Tester');
        $expected->setName('+420721010203');

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($expected, $model);
    }
}