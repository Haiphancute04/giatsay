<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Auth\Notifications\ResetPassword; 
use Illuminate\Notifications\Messages\MailMessage;


class User extends Authenticatable
{

    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',    
        'address',  
        'role',     
		'avatar',
        'password',
		'google_id',
        'facebook_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function donDatLichs()
    {
        return $this->hasMany(DonDatLich::class);
    }

    public function danhGias()
    {
        return $this->hasMany(DanhGia::class);
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->avatar) {
                    if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                        return $this->avatar;
                    }
                    return asset('storage/' . $this->avatar);
                }

                return asset('assets/img/default-user.png'); 
            },
        );
    }

    public function sendPasswordResetNotification($token) 
    { 
        $this->notify(new CustomResetPasswordNotification($token)); 
    } 

    public function vouchers()
    {
        return $this->belongsToMany(MaGiamGia::class, 'user_ma_giam_gia', 'user_id', 'ma_giam_gia_id')
                    ->withPivot('is_used', 'ngay_luu');
    }

    

}

class CustomResetPasswordNotification extends ResetPassword 
{ 
    public function toMail($notifiable) 
    { 
        return (new MailMessage) 
            ->subject('Khôi phục mật khẩu') 
            ->line('Bạn vừa yêu cầu ' . config('app.name') . ' khôi phục mật khẩu của mình.') 
            ->line('Liên kết đặt lại mật khẩu này sẽ hết hạn sau 60 phút.') 
            ->line('Xin vui lòng nhấn vào nút "Khôi phục mật khẩu" bên dưới để tiến hành cấp mật khẩu mới.') 
            ->action('Khôi phục mật khẩu', url(config('app.url') . route('password.reset', $this->token, false))) 
            ->line('Nếu bạn không yêu cầu đặt lại mật khẩu, xin vui lòng không làm gì thêm và báo lại cho quản trị hệ thống về vấn đề này.'); 
    } 
} 