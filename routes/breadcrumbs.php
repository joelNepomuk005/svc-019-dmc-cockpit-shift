<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Startseite', route('backend.dashboard.index'));
});

// Customers
Breadcrumbs::for('backend.customers', function ($trail) {
    $trail->parent('home');
    $trail->push('Sparkassen', route('backend.customers.index'));
});

// Campaigns
Breadcrumbs::for('backend.campaigns', function ($trail) {
    $trail->parent('home');
    $trail->push('Wettbewerb', route('backend.campaigns.index'));
});

// CustomerContacts
Breadcrumbs::for('backend.contacts', function ($trail) {
    $trail->parent('home');
    $trail->push('Kontakte', route('backend.contacts.index'));
});

// Measures
Breadcrumbs::for('backend.measures', function ($trail) {
    $trail->parent('home');
    $trail->push('Maßnahmen', route('backend.measures.index'));
});

// Measures -> Edit
Breadcrumbs::for('backend.measures.edit', function ($trail, $measure = false) {
    $trail->parent('home');
    $trail->push('Maßnahmen', route('backend.measures.index'));
    $trail->push($measure->name.' (#'.$measure->id.')');
});

// Users
Breadcrumbs::for('backend.users', function ($trail) {
    $trail->parent('home');
    $trail->push('Personen', route('backend.users.index'));
});

// Customer > Show
Breadcrumbs::for('backend.customer.show', function ($trail, $customer) {
    $trail->parent('home');
    $trail->push($customer->name.' ('.$customer->blz.')');
});

// Customer > Edit
Breadcrumbs::for('backend.customer.edit', function ($trail, $customer) {
    $trail->parent('home');
    $trail->push('Bearbeiten: '.$customer->name.' ('.$customer->blz.')');
});

// Customers > Edit / Create
Breadcrumbs::for('backend.customer.crud', function ($trail, $customer = false) {
    $trail->parent('home');
    $trail->parent('backend.customers');
    if ($customer != false) {
        if ($customer == 'create') {
            $trail->push('Neues Institut anlegen');
        } else {
            $trail->push($customer->name.' ('.$customer->blz.')', route('backend.customers.edit', $customer));
        }
    }
});
