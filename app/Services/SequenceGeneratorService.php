<?php

namespace App\Services;

use App\Models\Sequence;
use Carbon\Carbon;
use DateTime;
use Exception;

/**
 * This class is used to generate unique sequence numbers.
 * Each sequence has a prefix, suffix, next number, step and a length.
 * The prefix and suffix are optional.
 * The next number is incremented each time the sequence is generated.
 * The step is the number of numbers to increment the next number by.
 * The length is the number of numbers in the sequence.
 *
 */
class SequenceGeneratorService
{
  // Predefined constants to replace the sequence prefix and suffix.
  const PLACEHOLDERS = [
    '{{year}}' => 'Y', // Year
    '{{year_short}}' => 'y', // Year (short)
    '{{month}}' => 'm', // Month
    '{{day}}' => 'd', // Day
    '{{day_of_year}}' => 'z', // Day of year
    '{{day_of_week}}' => 'w', // Day of week
    '{{week_of_year}}' => 'W', // Week of year
    '{{h24}}' => 'H', // Hour (24-hour format)
    '{{h12}}' => 'h', // Hour (12-hour format)
    '{{min}}' => 'i', // Minute
    '{{sec}}' => 's', // Second
  ];

  /**
   * Generate a unique sequence number.
   *
   * @param string $sequenceCode
   * @return string
   * @throws Exception
   */
  public function generate(string $sequenceCode): string
  {
    $sequence = Sequence::query()->where('code', $sequenceCode)->first();

    if (!$sequence) {
      throw new Exception('Sequence not found.');
    }

    // Get the next value
    $value = $sequence->next_value;

    // Increment the next value by the step
    $nextValue = self::nextSequenceNumber($value, $sequence->step);

    // Update the sequence
    $sequence->next_value = $nextValue;

    // Save the sequence
    $sequence->save();

    // Generate the sequence number
    return $this->next($value, $sequence->length, $sequence->prefix, $sequence->suffix);
  }

  /**
   * Get the next sequence number.
   *
   * @param int $value The current value
   * @param int $length The length of the sequence number to generate (defaults to 1)
   * @param ?string $prefix The prefix of the sequence number (optional)
   * @param ?string $suffix The suffix of the sequence number (optional)
   * @return string
   */
  public function next(int $value, int $length = 1, ?string $prefix = '', ?string $suffix = ''): string
  {
    // Pad the value with zeros to the length of the sequence
    $value = str_pad($value, $length, '0', STR_PAD_LEFT);

    // Get the current date
    $currentDate = Carbon::now();

    // Replace placeholders
    $sequence_prefix = self::replacePlaceholders($currentDate, $prefix);
    $sequence_suffix = self::replacePlaceholders($currentDate, $suffix);

    return $sequence_prefix . $value . $sequence_suffix;
  }

  private static function replacePlaceholders(DateTime $dateTime, ?string $placeholders): string
  {
    if (!$placeholders) {
      return '';
    }

    preg_match_all('/{{(.*?)}}/', $placeholders, $matches);

    if (count($matches[0]) > 0) {
      // Replace placeholders with the current sequence value.
      foreach ($matches[0] as $match) {
        // Get placeholder value
        $value = self::PLACEHOLDERS[$match] ?? '';

        // Replace placeholder with value
        $placeholders = str_replace($match, $dateTime->format($value), $placeholders);
      }
    }

    return $placeholders;
  }

  private static function nextSequenceNumber(int $nextValue, int $step): int
  {
    return $nextValue + $step;
  }
}
