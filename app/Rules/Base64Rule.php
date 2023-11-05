<?php

namespace App\Rules;

use App\Filters\Makeable;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Traits\Conditionable;
use Symfony\Component\HttpFoundation\File\File;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/** @method static static make() */
class Base64Rule implements ValidationRule, ValidatorAwareRule
{
  use Conditionable;

  use Makeable;

  /**
   * The validator performing the validation.
   *
   * @var \Illuminate\Validation\Validator
   */
  protected $validator;

  /**
   * The MIME types that the given file should match. This array may also contain file extensions.
   *
   * @var array
   */
  protected $allowedMimetypes = [];

  /**
   * The minimum size in kilobytes that the file can be.
   *
   * @var null|int
   */
  protected $minimumFileSize = null;

  /**
   * The maximum size in kilobytes that the file can be.
   *
   * @var null|int
   */
  protected $maximumFileSize = null;

  /**
   * The minimum width in pixels that an image can be.
   *
   * @var null|int
   */
  protected $minimumWidth = null;

  /**
   * The maximum width in pixels that an image can be.
   *
   * @var null|int
   */
  protected $maximumWidth = null;

  /**
   * The width in pixels that an image can be.
   *
   * @var null|int
   */
  protected $width = null;

  /**
   * The minimum height in pixels that an image can be.
   *
   * @var null|int
   */
  protected $minimumHeight = null;

  /**
   * The maximum height in pixels that an image can be.
   *
   * @var null|int
   */
  protected $maximumHeight = null;

  /**
   * The height in pixels that an image can be.
   *
   * @var null|int
   */
  protected $height = null;

  /**
   * The ratio that an image must be.
   *
   * @var null|int
   */
  protected $ratio = null;

  /**
   * The file under validation.
   *
   * @var \Symfony\Component\HttpFoundation\File\File
   */
  protected $file;

  /**
   * This variable represents the file descriptor used to prevent PHP from deleting a file from the temporary folder.
   * @var resource
   */
  private $tmpFileDescriptor;

  /**
   * Set the maximum file size in kilobytes.
   *
   * @param  int  $kilobytes
   * @return $this
   */
  public function maxSize(int $kilobytes): static
  {
    $this->maximumFileSize = $kilobytes;

    return $this;
  }

  /**
   * Set the minimum file size in kilobytes.
   *
   * @param  int  $kilobytes
   * @return $this
   */
  public function minSize(int $kilobytes): static
  {
    $this->minimumFileSize = $kilobytes;

    return $this;
  }

  /**
   * Set the file size in kilobytes.
   *
   * @param  int  $kilobytes
   * @return $this
   */
  public function size(int $kilobytes): static
  {
    $this->minimumFileSize = $kilobytes;
    $this->maximumFileSize = $kilobytes;

    return $this;
  }

  /**
   * Set the file MIME types that are allowed.
   *
   * @param  string|array  $mimetypes
   * @return $this
   */
  public function mimeTypes(string|array $mimetypes): static
  {
    $mimetypes = is_array($mimetypes) ? $mimetypes : func_get_args();

    $this->allowedMimetypes = $mimetypes;

    return $this;
  }

  /**
   * Set the file size limits in kilobytes.
   *
   * @param  int  $min
   * @param  int  $max
   *
   * @return $this
   */
  public function between(int $min, int $max): static
  {
    $this->minimumFileSize = $min;
    $this->maximumFileSize = $max;

    return $this;
  }

  /**
   * Set the minimum width of the image.
   *
   * @param  int  $width
   * @return $this
   */
  public function minWidth(int $width): static
  {
    $this->minimumWidth = $width;

    return $this;
  }

  /**
   * Set the maximum width of the image.
   *
   * @param  int  $width
   * @return $this
   */
  public function maxWidth(int $width): static
  {
    $this->maximumWidth = $width;

    return $this;
  }

  /**
   * Set the width of the image.
   *
   * @param  int  $width
   * @return $this
   */
  public function width(int $width): static
  {
    $this->width = $width;

    return $this;
  }

  /**
   * Set the minimum height of the image.
   *
   * @param  int  $height
   * @return $this
   */
  public function minHeight(int $height): static
  {
    $this->minimumHeight = $height;

    return $this;
  }

  /**
   * Set the maximum height of the image.
   *
   * @param  int  $height
   * @return $this
   */
  public function maxHeight(int $height): static
  {
    $this->maximumHeight = $height;

    return $this;
  }

  /**
   * Set the height of the image.
   *
   * @param  int  $height
   * @return $this
   */
  public function height(int $height): static
  {
    $this->height = $height;

    return $this;
  }

  /**
   * Set the ratio of the image.
   *
   * @param float  $value
   * @return $this
   */
  public function ratio(float $value): static
  {
    $this->ratio = $value;

    return $this;
  }

  /**
   * Validate the size of an incoming file.
   *
   * @param  string  $attribute
   * @param  \Symfony\Component\HttpFoundation\File\File  $file
   * @param  \Closure  $fail
   *
   * @return void
   */
  protected function validateSize(string $attribute, File $file, Closure $fail)
  {
    if (is_null($this->minimumFileSize) && is_null($this->maximumFileSize)) {
      return;
    }

    //  && $file->getSize() < $this->minimumFileSize
    if (is_null($this->maximumFileSize) && !$this->validator->validateMin($attribute, $file, [$this->minimumFileSize])) {
      $fail('validation.min.file')
        ->translate([
          'min' => $this->minimumFileSize
        ]);
      return;
    }

    if (is_null($this->minimumFileSize) && !$this->validator->validateMax($attribute, $file, [$this->maximumFileSize])) {
      $fail('validation.max.file')
        ->translate([
          'max' => $this->maximumFileSize
        ]);
      return;
    }

    if ($this->minimumFileSize !== $this->maximumFileSize && !$this->validator->validateBetween($attribute, $file, [$this->minimumFileSize, $this->maximumFileSize])) {
      $fail('validation.between.file')
        ->translate([
          'min' => $this->minimumFileSize,
          'max' => $this->maximumFileSize
        ]);
      return;
    }

    $size = $this->minimumFileSize;

    if (!$this->validator->validateSize($attribute, $file, [$size])) {
      $fail('validation.size.file')
        ->translate([
          'size' => $size
        ]);
      return;
    }
  }

  /**
   * Validate the mime type of an incoming file.
   *
   * @param  string  $attribute
   * @param  \Symfony\Component\HttpFoundation\File\File  $file
   * @param  \Closure  $fail
   *
   * @return void
   */
  protected function validateMimetypes(string $attribute, File $file, Closure $fail)
  {
    if (count($this->allowedMimetypes) === 0) {
      return;
    }

    $mimetypes = array_filter(
      $this->allowedMimetypes,
      fn($type) => str_contains($type, '/')
    );

    $mimes = array_diff($this->allowedMimetypes, $mimetypes);

    if (count($mimetypes) > 0) {
      if (!$this->validator->validateMimetypes($attribute, $file, $mimetypes)) {
        $fail('validation.mimetypes')
          ->translate([
            'values' => implode(', ', $mimetypes)
          ]);
      }
    }

    if (count($mimes) > 0) {
      if (!$this->validator->validateMimes($attribute, $file, $mimes)) {
        $fail('validation.mimes')
          ->translate([
            'values' => implode(', ', $mimes)
          ]);
      }
    }
  }

  /**
   * Validate the dimensions of an incoming file.
   *
   * @param  string  $attribute
   * @param  \Symfony\Component\HttpFoundation\File\File  $file
   * @param  \Closure  $fail
   *
   * @return void
   */
  protected function validateDimensions(string $attribute, File $file, Closure $fail)
  {
    $dimensions = array_filter([
      'max_width' => $this->maximumWidth,
      'min_width' => $this->minimumWidth,
      'width' => $this->width,

      'max_height' => $this->maximumHeight,
      'min_height' => $this->minimumHeight,
      'height' => $this->height,

      'ratio' => $this->ratio
    ]);

    $dimensions = implode(',', array_map(function ($key) use ($dimensions) {
      return "$key=$dimensions[$key]";
    }, array_keys($dimensions)));

    if (!$this->validator->validateDimensions($attribute, $file, ['dimensions' => $dimensions])) {
      $fail('validation.dimensions')->translate();
    }
  }

  public function validate(string $attribute, mixed $value, Closure $fail): void
  {
    $file = $this->getFile($value);

    if (!$this->validator->validateFile($attribute, $file)) {
      $fail('validation.file')->translate();
      return;
    }

    // Validate the file type
    if (!$this->validator->validateImage($attribute, $file)) {
      $fail('validation.image')->translate();
      return;
    }

    // Validate the file size
    $this->validateSize($attribute, $file, $fail);

    // Validate the file MIME type
    $this->validateMimetypes($attribute, $file, $fail);

    // Validate the file dimensions
    $this->validateDimensions($attribute, $file, $fail);
  }

  /**
   * @param ?string $base64
   *
   * @return ?File
   */
  protected function getFile(?string $base64): ?File
  {
    if (is_null($base64))
      return null;

    if (isset($this->file)) {
      return $this->file;
    }

    if (strpos($base64, ';base64') !== false) {
      [, $base64] = explode(';', $base64);
      [, $base64] = explode(',', $base64);
    }

    $binaryData = base64_decode($base64);
    $tmpFile = tmpfile();
    $this->tmpFileDescriptor = $tmpFile;
    $tmpFilePath = stream_get_meta_data($tmpFile)['uri'];

    file_put_contents($tmpFilePath, $binaryData);

    return $this->file = new File($tmpFilePath);
  }

  /**
   * Set the current validator.
   *
   * @param  \Illuminate\Contracts\Validation\Validator  $validator
   * @return $this
   */
  public function setValidator($validator)
  {
    $this->validator = $validator;

    return $this;
  }
}
