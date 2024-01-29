<?php

class DataValidator
{
  private string $inputName = "";
  private string $inputValue = "";
  private array $errors = [];
  private bool $validated = true;

  //------------------------------------------------------------
  public function __invoke(string $inputName, string $inputValue): self
  //------------------------------------------------------------
  {
    $this->inputName = $inputName;
    $this->inputValue = $inputValue;
    $this->errors[$inputName] = [];

    return $this;
  }

  //------------------------------------------------------------
  public function isValidated(): bool
  //------------------------------------------------------------
  {
    return $this->validated;
  }

  //------------------------------------------------------------
  public function required(): self
  //------------------------------------------------------------
  {
    if (empty($this->inputValue)) {
      $this->errors[$this->inputName][] = "{$this->inputName} is required.";
      $this->validated = false;
    }
    return $this;
  }

  //------------------------------------------------------------
  public function min(int $length): self
  //------------------------------------------------------------
  {
    if (strlen($this->inputValue) < $length) {
      $this->errors[$this->inputName][] = "{$this->inputName} must be at least {$length} characters long.";
      $this->validated = false;
    }
    return $this;
  }

  //------------------------------------------------------------
  public function max(int $length): self
  //------------------------------------------------------------
  {
    if (strlen($this->inputValue) > $length) {
      $this->errors[$this->inputName][] = "{$this->inputName} must be no more than {$length} characters long.";
      $this->validated = false;
    }
    return $this;
  }

  //------------------------------------------------------------
  public function number(): self
  //------------------------------------------------------------
  {
    if (!is_numeric($this->inputValue)) {
      $this->errors[$this->inputName][] = "{$this->inputName} must be a number.";
      $this->validated = false;
    }
    return $this;
  }

  //------------------------------------------------------------
  public function addError(string $field, string $error): self
  //------------------------------------------------------------
  {
    $this->errors[$field][] = $error;
    $this->validated = false;

    return $this;
  }

  //------------------------------------------------------------
  public function getErrors(): string
  //------------------------------------------------------------
  {
    // Extract the first value from each array
    $firstValues = array_column($this->errors, 0);
    // Re-index the array
    $result = array_values($firstValues);

    // Return just the first Input Error
    return implode("<br>", $result);
  }
}
