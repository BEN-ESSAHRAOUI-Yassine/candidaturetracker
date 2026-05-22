# CandidatureTracker - Design Document

## Architecture

Application Laravel de suivi de candidatures. Authentification requise pour la majorité des fonctionnalités. Chaque utilisateur gère ses propres candidatures, entretiens et documents.

---

## Routes

### Routes publiques (web)

| Méthode | URI | Nom | Controller@method | Middleware |
|---------|-----|-----|-------------------|-----------|
| GET | `/` | — | `view('welcome')` | web |
| GET | `/register` | `register` | `RegisteredUserController@create` | guest |
| POST | `/register` | — | `RegisteredUserController@store` | guest |
| GET | `/login` | `login` | `AuthenticatedSessionController@create` | guest |
| POST | `/login` | — | `AuthenticatedSessionController@store` | guest |
| GET | `/forgot-password` | `password.request` | `PasswordResetLinkController@create` | guest |
| POST | `/forgot-password` | `password.email` | `PasswordResetLinkController@store` | guest |
| GET | `/reset-password/{token}` | `password.reset` | `NewPasswordController@create` | guest |
| POST | `/reset-password` | `password.store` | `NewPasswordController@store` | guest |
| POST | `/logout` | `logout` | `AuthenticatedSessionController@destroy` | auth |

### Routes authentifiées

| Méthode | URI | Nom | Controller@method | Middleware |
|---------|-----|-----|-------------------|-----------|
| GET | `/dashboard` | `dashboard` | `CandidatureController@dashboardStats` | auth, verified |
| GET | `/candidatures` | `candidatures.index` | `CandidatureController@index` | auth |
| GET | `/candidatures/create` | `candidatures.create` | `CandidatureController@create` | auth |
| POST | `/candidatures` | `candidatures.store` | `CandidatureController@store` | auth |
| GET | `/candidatures/{candidature}` | `candidatures.show` | `CandidatureController@show` | auth |
| GET | `/candidatures/{candidature}/edit` | `candidatures.edit` | `CandidatureController@edit` | auth |
| PUT | `/candidatures/{candidature}` | `candidatures.update` | `CandidatureController@update` | auth |
| DELETE | `/candidatures/{candidature}` | `candidatures.destroy` | `CandidatureController@destroy` | auth |
| GET | `/archives` | `candidatures.archives` | `CandidatureController@archives` | auth |
| PATCH | `/candidatures/{id}/restore` | `candidatures.restore` | `CandidatureController@restore` | auth |
| DELETE | `/candidatures/{id}/force-delete` | `candidatures.force-destroy` | `CandidatureController@forceDestroy` | auth |
| POST | `/candidatures/{candidature}/entretiens` | `entretiens.store` | `EntretienController@store` | auth |
| GET | `/entretiens/{entretien}/edit` | `entretiens.edit` | `EntretienController@edit` | auth |
| PUT | `/entretiens/{entretien}` | `entretiens.update` | `EntretienController@update` | auth |
| DELETE | `/entretiens/{entretien}` | `entretiens.destroy` | `EntretienController@destroy` | auth |
| GET | `/documents/{document}/download` | `documents.download` | `DocumentController@download` | auth |
| DELETE | `/documents/{document}` | `documents.destroy` | `DocumentController@destroy` | auth |
| GET | `/profile` | `profile.edit` | `ProfileController@edit` | auth |
| PATCH | `/profile` | `profile.update` | `ProfileController@update` | auth |
| DELETE | `/profile` | `profile.destroy` | `ProfileController@destroy` | auth |
| GET | `/verify-email` | `verification.notice` | `EmailVerificationPromptController` | auth |
| GET | `/verify-email/{id}/{hash}` | `verification.verify` | `VerifyEmailController` | auth, signed |
| POST | `/email/verification-notification` | `verification.send` | `EmailVerificationNotificationController@store` | auth |
| GET | `/confirm-password` | `password.confirm` | `ConfirmablePasswordController@show` | auth |
| POST | `/confirm-password` | — | `ConfirmablePasswordController@store` | auth |
| PUT | `/password` | `password.update` | `PasswordController@update` | auth |

---

## Controllers

### App\Http\Controllers\CandidatureController

| Méthode | Vue retournée | Variables compactées |
|---------|---------------|---------------------|
| `index()` | `candidatures.index` | `candidatures` (collection filtrée par statut/priorité, avec entretiens & documents) |
| `create()` | `candidatures.create` | — |
| `store()` | redirect → `candidatures.index` | — |
| `show()` | `candidatures.show` | `candidature` (avec entretiens & documents) |
| `edit()` | `candidatures.edit` | `candidature` |
| `update()` | redirect → `candidatures.show` | — |
| `destroy()` | redirect → `candidatures.index` (soft delete) | — |
| `archives()` | `candidatures.archives` | `candidatures` (onlyTrashed) |
| `restore()` | redirect → `candidatures.archives` | — |
| `forceDestroy()` | redirect → `candidatures.archives` | — |
| `dashboardStats()` | `dashboard` | `totalCandidatures`, `enAttente`, `entretiensPlanifies`, `offresRecues`, `refusees`, `statistiquesParStatut`, `candidaturesRecent`, `prochainsEntretiens` |

### App\Http\Controllers\EntretienController

| Méthode | Vue retournée | Variables compactées |
|---------|---------------|---------------------|
| `store()` | redirect → `candidatures.show` | — |
| `edit()` | `entretiens.edit` | `entretien` |
| `update()` | redirect → `candidatures.show` | — |
| `destroy()` | redirect → `candidatures.show` | — |

### App\Http\Controllers\DocumentController

| Méthode | Vue retournée | Variables compactées |
|---------|---------------|---------------------|
| `download()` | Storage download | — |
| `destroy()` | redirect → back() | — |

### App\Http\Controllers\ProfileController

| Méthode | Vue retournée | Variables |
|---------|---------------|-----------|
| `edit()` | `profile.edit` | `['user' => $request->user()]` |
| `update()` | redirect → `profile.edit` | — |
| `destroy()` | redirect → `/` | — |

### Auth Controllers

| Controller | Méthode | Vue |
|------------|---------|-----|
| `AuthenticatedSessionController` | `create()` | `auth.login` |
| `RegisteredUserController` | `create()` | `auth.register` |
| `PasswordResetLinkController` | `create()` | `auth.forgot-password` |
| `NewPasswordController` | `create()` | `auth.reset-password` (variable: `request`) |
| `ConfirmablePasswordController` | `show()` | `auth.confirm-password` |
| `EmailVerificationPromptController` | `__invoke()` | `auth.verify-email` |

---

## Models

### App\Models\User

| Propriété | Détail |
|-----------|--------|
| Table | `users` |
| Fillable | `name`, `email`, `password` |
| Hidden | `password`, `remember_token` |
| Casts | `email_verified_at` → `datetime`, `password` → `hashed` |
| Relations | `candidatures()` → `hasMany(Candidature::class)` |

### App\Models\Candidature

| Propriété | Détail |
|-----------|--------|
| Table | `candidatures` |
| Traits | `HasFactory`, `SoftDeletes` |
| Fillable | `user_id`, `entreprise`, `poste`, `offre_url`, `statut`, `priorite`, `notes`, `date_candidature` |
| Accessors | `getStatutLabelAttribute()`, `getPrioriteLabelAttribute()` |
| Relations | `user()` → `belongsTo(User::class)`, `entretiens()` → `hasMany(Entretien::class)`, `documents()` → `hasMany(Document::class)` |

### App\Models\Entretien

| Propriété | Détail |
|-----------|--------|
| Table | `entretiens` |
| Traits | `HasFactory` |
| Fillable | `candidature_id`, `type`, `date_entretien`, `notes_preparation`, `resultat` |
| Accessors | `getTypeLabelAttribute()`, `getResultatLabelAttribute()` |
| Relations | `candidature()` → `belongsTo(Candidature::class)` |

### App\Models\Document

| Propriété | Détail |
|-----------|--------|
| Table | `documents` |
| Traits | `HasFactory` |
| Fillable | `candidature_id`, `nom_fichier`, `chemin_stockage`, `type_mime` |
| Relations | `candidature()` → `belongsTo(Candidature::class)` |

---

## Views

### Layouts

| Fichier | Description | Composants utilisés |
|---------|-------------|---------------------|
| `layouts/app.blade.php` | Layout principal connecté — slot `$header`, slot par défaut `$slot` | `layouts.navigation` (include) |
| `layouts/guest.blade.php` | Layout invité (login/register) | `components.application-logo` |
| `layouts/navigation.blade.php` | Barre de navigation avec dropdown utilisateur | `nav-link`, `responsive-nav-link`, `dropdown`, `dropdown-link` |

### Pages principales

| Fichier | Variables | Composants utilisés |
|---------|-----------|---------------------|
| `welcome.blade.php` | — (aucune variable) | Aucun composant blade (HTML statique) |
| `dashboard.blade.php` | `totalCandidatures`, `enAttente`, `entretiensPlanifies`, `offresRecues`, `refusees`, `statistiquesParStatut`, `candidaturesRecent`, `prochainsEntretiens` | `app-layout` |

### Candidatures

| Fichier | Variables/Données | Composants utilisés |
|---------|-------------------|---------------------|
| `candidatures/index.blade.php` | `$candidatures` (forelse) — entreprise, poste, statut_label, priorite_label, date_candidature | `app-layout`, `input-label`, `primary-button` |
| `candidatures/create.blade.php` | `old()` — entreprise, poste, offre_url, statut, priorite, date_candidature, document, notes | `app-layout`, `input-label`, `text-input`, `input-error`, `primary-button` |
| `candidatures/show.blade.php` | `$candidature` — affiche détail, boucle entretiens (forelse), boucle documents (forelse), formulaire ajout entretien | `app-layout`, `input-label`, `text-input`, `input-error`, `primary-button` |
| `candidatures/edit.blade.php` | `$candidature`, `old('x', $candidature->x)` — entreprise, poste, offre_url, statut, priorite, date_candidature, notes | `app-layout`, `input-label`, `text-input`, `input-error`, `primary-button` |
| `candidatures/archives.blade.php` | `$candidatures` (forelse) — deleted_at, boutons restore/force-delete | `app-layout` |

### Entretiens

| Fichier | Variables/Données | Composants utilisés |
|---------|-------------------|---------------------|
| `entretiens/edit.blade.php` | `$entretien` — type, date_entretien, resultat, notes_preparation | `app-layout`, `input-label`, `text-input`, `input-error`, `primary-button` |

### Profile

| Fichier | Variables/Données | Composants utilisés |
|---------|-------------------|---------------------|
| `profile/edit.blade.php` | Inclut 3 partials | `app-layout` |
| `profile/partials/update-profile-information-form.blade.php` | `$user` — name, email | `input-label`, `text-input`, `input-error`, `primary-button` |
| `profile/partials/update-password-form.blade.php` | — | `input-label`, `text-input`, `input-error`, `primary-button` |
| `profile/partials/delete-user-form.blade.php` | — | `danger-button`, `modal`, `input-label`, `text-input`, `input-error`, `secondary-button` |

### Auth

| Fichier | Composants utilisés |
|---------|---------------------|
| `auth/login.blade.php` | `guest-layout`, `auth-session-status`, `input-label`, `text-input`, `input-error`, `primary-button` |
| `auth/register.blade.php` | `guest-layout`, `input-label`, `text-input`, `input-error`, `primary-button` |
| `auth/forgot-password.blade.php` | `guest-layout`, `auth-session-status`, `input-label`, `text-input`, `input-error`, `primary-button` |
| `auth/reset-password.blade.php` | `guest-layout` |
| `auth/verify-email.blade.php` | `guest-layout`, `primary-button` |
| `auth/confirm-password.blade.php` | `guest-layout`, `input-label`, `text-input`, `input-error`, `primary-button` |

---

## Blade Components

### PHP Components (`app/View/Components/`)

| Classe | Vue rendue |
|--------|------------|
| `AppLayout` | `layouts.app` |
| `GuestLayout` | `layouts.guest` |

### Blade Components (`resources/views/components/`)

| Fichier | Props | Description |
|---------|-------|-------------|
| `application-logo.blade.php` | `$attributes` | Logo SVG Laravel |
| `auth-session-status.blade.php` | `$status` | Message de statut vert |
| `primary-button.blade.php` | `$attributes` (type=submit) | Bouton de soumission gris |
| `secondary-button.blade.php` | `$attributes` (type=button) | Bouton d'annulation blanc |
| `danger-button.blade.php` | `$attributes` (type=submit) | Bouton de suppression rouge |
| `text-input.blade.php` | `$disabled`, `$attributes` | Champ input texte |
| `input-label.blade.php` | `$value` | Étiquette de champ |
| `input-error.blade.php` | `$messages` | Liste d'erreurs de validation |
| `nav-link.blade.php` | `$active` | Lien de navigation |
| `responsive-nav-link.blade.php` | `$active` | Lien de navigation mobile |
| `dropdown.blade.php` | `$align`, `$width`, `$contentClasses`, slots `trigger`/`content` | Dropdown Alpine.js |
| `dropdown-link.blade.php` | `$attributes` | Lien dans un dropdown |
| `modal.blade.php` | `$name`, `$show`, `$maxWidth` | Modale Alpine.js |

---

## Form Requests

| Classe | Règles |
|--------|--------|
| `StoreCandidatureRequest` | entreprise (required\|string\|max:255), poste (required\|string\|max:255), offre_url (nullable\|url), statut (required\|in:en_attente,acceptee,refusee,entretien,relance), priorite (required\|in:basse,moyenne,haute), notes (nullable\|string), date_candidature (required\|date) |
| `UpdateCandidatureRequest` | Identique à Store |
| `StoreEntretienRequest` | Règles entretien |
| `UpdateEntretienRequest` | Règles entretien |
| `ProfileUpdateRequest` | name, email |

---

## Policies

| Policy | Méthodes | Vérification |
|--------|----------|-------------|
| `CandidaturePolicy` | view, update, delete, restore, forceDelete | `$user->id === $candidature->user_id` |
| `EntretienPolicy` | view, update, delete, restore, forceDelete | `$user->id === $entretien->candidature->user_id` |

---

## Services / Providers

| Provider | Rôle |
|----------|------|
| `AppServiceProvider` | Vide (register/boot par défaut) |
| `AuthServiceProvider` | Enregistre les policies Candidature et Entretien |
| `TelescopeServiceProvider` | Debug bar (local uniquement) |
