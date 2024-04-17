<?php

namespace Validator;

class RegistrationFormValidator
{
    private string $name;
    private string $email;
    private ?array $avatar;
    private string $password;
    private  string $passwordConfirmation;

    public function __construct(string $name, string $email, string $password,  string $passwordConfirmation,  array $avatar = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
        $this->avatar = $avatar;
    }

    public function setValidationErrors(): array
    {
        $possibleErrors = array_merge(
            $this->setPossibleError('name', $this->validateName()),
            $this->setPossibleError('email', $this->validateEmail()),
            $this->setPossibleError('password', $this->validatePassword()),
            $this->setPossibleError('passwordConfirmation', $this->validatePasswordConfirmation()),
            $this->setPossibleError('avatar', $this->validateProfilePhoto())
        );

        $currentErrors = [];

        foreach ($possibleErrors as $key => $error)
        {
            if (!empty($error)){
                $currentErrors[$key] = $error;
            }
        }
        return $currentErrors;
    }

    private function setPossibleError($key, $error): array
    {
        return [$key => $error];
    }


    private function validateName() : string
    {
        if (empty($this->name) || preg_match('/[^A-Za-z0-9\s]/', $this->name)){
            return "Неверный формат имени";
        }
        return '';
    }

    private function validateEmail(): string
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            return "Некорректная почта";
        }
        return "";
    }

    private function validatePassword(): string
    {
        if (empty($this->password)){
            return "Введите пароль";
        }
        return "";

    }
    private function validatePasswordConfirmation(): string
    {
        if($this->password !== $this->passwordConfirmation){
            return "Пароли не совпадают";
        }
        return "";
    }

    private function validateProfilePhoto(): string
    {
        if (!empty($this->avatar) && $this->avatar['error'] == 0){
                $typesOfImage = ['image/jpeg', 'image/png'];
                return in_array($this->avatar['type'], $typesOfImage) ? '' : "Изображение имеет неверный тип";
        }
        return "";
    }



}

