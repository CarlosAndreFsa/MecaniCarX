<div style="font-family: Arial, sans-serif; color: #1f2937;">
    <h2>Olá, {{ $customer->name }}</h2>
    <p>Seu usuário de acesso ao MecaniCarX foi criado.</p>
    <p><strong>Email:</strong> {{ $customer->email }}</p>
    <p><strong>Senha temporária:</strong> {{ $temporaryPassword }}</p>
    <p><a href="{{ $loginUrl }}" style="display: inline-block; background: #ea580c; color: #ffffff; padding: 10px 16px; border-radius: 8px; text-decoration: none; font-weight: bold;">Acessar o sistema</a></p>
    <p>Por segurança, altere sua senha após o primeiro acesso.</p>
</div>
