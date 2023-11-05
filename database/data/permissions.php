<?php
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\MailServer;
use App\Models\MeasureUnitCategory;
use App\Models\School;
use App\Models\Sequence;
use App\Models\State;
use App\Models\Translation;
use App\Models\User;
use App\Permissions\PermissionBlueprint;
use App\Permissions\PermissionDescriptor;

return PermissionDescriptor::make()
  ->add(null, null, '*', 'Super Admin Power')
  ->inModule('base', function (PermissionBlueprint $blueprint) {
    // User Permissions
    $blueprint->forModel(User::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List Users');
      $blueprint->add('show', 'Show User');
      $blueprint->add('store', 'Store User');
      $blueprint->add('update', 'Update User');
      $blueprint->add('destroy', 'Delete User');
      $blueprint->add('updateAny', 'Update Any User');
      $blueprint->add('deleteAny', 'Delete Any User');
    });

    // Country Permissions
    $blueprint->forModel(Country::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List Countries');
      $blueprint->add('show', 'Show Country');
      $blueprint->add('store', 'Store Country');
      $blueprint->add('update', 'Update Country');
      $blueprint->add('destroy', 'Delete Country');
    });

    // State Permissions
    $blueprint->forModel(State::class, function ($blueprint) {
      $blueprint->add('index', 'List States');
      $blueprint->add('show', 'Show State');
      $blueprint->add('store', 'Store State');
      $blueprint->add('update', 'Update State');
      $blueprint->add('destroy', 'Delete State');
    });

    // City Permissions
    $blueprint->forModel(City::class, function ($blueprint) {
      $blueprint->add('index', 'List Cities');
      $blueprint->add('show', 'Show City');
      $blueprint->add('store', 'Store City');
      $blueprint->add('update', 'Update City');
      $blueprint->add('destroy', 'Delete City');
    });

    // Currency Permissions
    $blueprint->forModel(Currency::class, function ($blueprint) {
      $blueprint->add('index', 'List Currencies');
      $blueprint->add('show', 'Show Currency');
      $blueprint->add('store', 'Store Currency');
      $blueprint->add('update', 'Update Currency');
      $blueprint->add('destroy', 'Delete Currency');
    });

    // Measure Unit Category Permissions
    $blueprint->forModel(MeasureUnitCategory::class, function ($blueprint) {
      $blueprint->add('index', 'List UOM Categories');
      $blueprint->add('show', 'Show UOM Category');
      $blueprint->add('store', 'Store UOM Category');
      $blueprint->add('update', 'Update UOM Category');
      $blueprint->add('destroy', 'Delete UOM Category');
    });

    // Sequence Permissions
    $blueprint->forModel(Sequence::class, function ($blueprint) {
      $blueprint->add('index', 'List Sequences');
      $blueprint->add('show', 'Show Sequence');
      $blueprint->add('store', 'Store Sequence');
      $blueprint->add('update', 'Update Sequence');
      $blueprint->add('destroy', 'Delete Sequence');
    });

    // Mail Server Permissions
    $blueprint->forModel(MailServer::class, function ($blueprint) {
      $blueprint->add('index', 'List Mail Servers');
      $blueprint->add('show', 'Show Mail Server');
      $blueprint->add('store', 'Store Mail Server');
      $blueprint->add('update', 'Update Mail Server');
      $blueprint->add('destroy', 'Delete Mail Server');
    });

    // Translation Permissions
    $blueprint->forModel(Translation::class, function ($blueprint) {
      $blueprint->add('index', 'List Translations');
      $blueprint->add('show', 'Show Translation');
      $blueprint->add('store', 'Store Translation');
      $blueprint->add('update', 'Update Translation');
      $blueprint->add('destroy', 'Delete Translation');
    });

    // School Permissions
    $blueprint->forModel(School::class, function ($blueprint) {
      $blueprint->add('index', 'List School');
      $blueprint->add('show', 'Show School');
      $blueprint->add('store', 'Store School');
      $blueprint->add('update', 'Update School');
      $blueprint->add('destroy', 'Delete School');
    });
  });
