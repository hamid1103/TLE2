<script>
    import {useForm} from "@inertiajs/svelte";

    let RegForm = useForm({
        email: null,
        password: null,
        password_confirm: null,
        name: null
    })
    function register (){
        console.log('register function called')
        $RegForm.post('/register')
    }


    /*const register = async () => {
        console.log('register function called');
        try {
            const response = await fetch('/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name,
                    email,
                    password,
                    password_confirmation
                })
            });

            if (response.ok) {
                window.location.href = '/login';
            } else {
                const errors = await response.json();
                console.error(errors);
            }
        } catch (error) {
            console.error('Error in register function:', error); // Nieuwe console.error
        }
    };*/
</script>

<div class="h-screen flex flex-col">
    <header class="bg-[#40A0C1] h-12 flex items-center justify-center">
    </header>

    <main class="flex-1 bg-[#C4F0FF] flex items-center justify-center p-4 md:p-8">
        <div class="bg-white p-4 md:p-8 rounded shadow-lg text-center w-full max-w-md">
            <h1 class="text-xl md:text-2xl mb-4">Registreren</h1>
            <form on:submit|preventDefault={register}>
                <input
                    type="text"
                    placeholder="Naam"
                    bind:value={$RegForm.name}
                    class="block w-full px-4 py-2 mb-4 border rounded border-gray-300"
                    required
                />
                <input
                    type="email"
                    placeholder="E-mailadres"
                    bind:value={$RegForm.email}
                    class="block w-full px-4 py-2 mb-4 border rounded border-gray-300"
                    required
                />
                <input
                    type="password"
                    placeholder="Wachtwoord"
                    bind:value={$RegForm.password}
                    class="block w-full px-4 py-2 mb-4 border rounded border-gray-300"
                    required
                />
                <input
                    type="password"
                    placeholder="Bevestig Wachtwoord"
                    bind:value={$RegForm.password_confirm}
                    class="block w-full px-4 py-2 mb-4 border rounded border-gray-300"
                    required
                />
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Registreren</button>
                <p class="mt-4">
                    Heb je al een account?
                </p>
                <p>
                    <a href="http://127.0.0.1:8000/login" class="text-blue-500">Inloggen</a>
                </p>
            </form>
        </div>
    </main>
</div>
