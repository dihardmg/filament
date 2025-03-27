<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use App\Notifications\TwoFactorResetNotification;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Support\Enums\ActionSize;
use Illuminate\Validation\Rule;




class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn($state) => bcrypt($state))
                    ->dehydrated(fn($state) => filled($state)),
            ]);
    }

    public static function table(Table $table): Table
    {
        /* return $table
            ->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama'),
            Tables\Columns\TextColumn::make('email')->label('Email'),
            Tables\Columns\TextColumn::make('google2fa_secret')
                    ->label('2FA')
                    ->formatStateUsing(fn($state) => $state ? 'Aktif' : 'Tidak Aktif'),
            ])
            ->actions([
                Action::make('reset2fa')
                    ->label('Reset 2FA')
                    ->color('danger')
                    ->icon('heroicon-o-shield-exclamation')
                    ->requiresConfirmation()
                    ->action(function (User $record) {
                        $record->google2fa_secret = null;
                        $record->save();

                        Notification::make()
                            ->title('2FA berhasil direset')
                            ->success()
                            ->send();

                        $record->notify(new TwoFactorResetNotification());
                    }),
            ]); */
            return $table
        ->columns([

            TextColumn::make('no')
                ->label('No')
                ->rowIndex()
                ->alignCenter()
                ->toggleable(false),

            TextColumn::make('name')
                ->label('Nama')
                ->searchable()
                ->toggleable(), // toggle column

            TextColumn::make('email')
                ->label('Email')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false),

            /* TextColumn::make('google2fa_secret')
                ->label('2FA')
                ->formatStateUsing(fn ($state) => $state ? 'Aktif' : 'Tidak Aktif')
                ->toggleable(isToggledHiddenByDefault: true),
                 */
            BadgeColumn::make('2fa_status')
                ->label('2FA')
                ->getStateUsing(fn($record) => $record->google2fa_secret ? 'Aktif' : 'Tidak Aktif')
                ->colors([
                    'success' => 'Aktif',
                    'gray' => 'Tidak Aktif',
                ])
                ->icons([
                    'heroicon-o-lock-closed' => 'Aktif',
                    'heroicon-o-lock-open' => 'Tidak Aktif',
                ])
        ])
        ->filters([
            SelectFilter::make('2fa_status')
            ->label('Status 2FA')
            ->options([
                'aktif' => 'Aktif',
                'tidak' => 'Tidak Aktif',
            ])
            ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data) {
                return match ($data['value']) {
                    'aktif' => $query->whereNotNull('google2fa_secret'),
                    'tidak' => $query->whereNull('google2fa_secret'),
                    default => $query,
                };
            }),
        ])
        ->actions([
            // Action::make('reset2fa')
            //     ->label('Reset 2FA')
            //     ->icon('heroicon-o-shield-exclamation')
            //     ->color('danger')
            //     ->requiresConfirmation()
            //     ->action(function ($record) {
            //         $record->google2fa_secret = null;
            //         $record->save();

            //         Notification::make()
            //             ->title('2FA berhasil direset')
            //             ->success()
            //             ->send();

            //         $record->notify(new \App\Notifications\TwoFactorResetNotification());
            //     }),
            ActionGroup::make([
                EditAction::make(),

                DeleteAction::make(),

                Action::make('reset2fa')
                    ->label('Reset 2FA')
                    ->icon('heroicon-o-shield-exclamation')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn($record) => filled($record->google2fa_secret))
                    ->action(function ($record) {
                        $record->google2fa_secret = null;
                        $record->save();

                        Notification::make()
                            ->title('2FA berhasil direset')
                            ->success()
                            ->send();

                        $record->notify(new \App\Notifications\TwoFactorResetNotification());
                    }),
            ])
                ->label('More actions') // Optional: shown in tooltip
                ->icon('heroicon-m-ellipsis-vertical')
                ->size(ActionSize::Small)
                ->color('primary')
                ->button(), // Render as a button, not inline
        ])
        ->paginated([10, 25, 50]) // pilihan jumlah per halaman
        ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
