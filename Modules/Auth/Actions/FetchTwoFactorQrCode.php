<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\Auth\Models\User;
use PragmaRX\Google2FA\Google2FA;

final readonly class FetchTwoFactorQrCode
{
    public function __construct(
        private LoggedUser $loggedUser,
        private Google2FA $google2fa
    ) {}

    public function handle(): array
    {
        $user = $this->loggedUser->handle();
        $secret = decrypt($user->two_factor_secret);

        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);

        return [
            'qr_code_url' => $qrCodeUrl,
            'secret' => $secret,
            'recovery_codes' => $recoveryCodes,
        ];
    }
}
