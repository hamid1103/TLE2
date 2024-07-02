<script>
    import {useForm} from "@inertiajs/svelte";

    // let email = '';
    // let password = '';

    let LForm = useForm({
        login: null,
        password: null,
        remember: false,
    })

    function login() {
        console.log('login function called')
        $LForm.post('/login')
    }



</script>

<div class="h-screen flex flex-col">
    <header class="bg-[#40A0C1] h-12 flex items-center justify-center">
    </header>

    <main class="flex-1 bg-[#C4F0FF] flex items-center justify-center p-4 md:p-8">
        <div class="bg-white p-4 md:p-8 rounded shadow-lg text-center w-full max-w-md">
            <h1 class="text-xl md:text-2xl mb-4">Inloggen</h1>
            <form on:submit|preventDefault={login}>
                <input
                    type="email"
                    placeholder="E-mailadres"
                    bind:value={$LForm.login}
                    class="block w-full px-4 py-2 mb-4 border rounded border-gray-300"
                    required
                />
                {#if $LForm.errors.login}
                    <p class="text-red-500">{$LForm.errors.login}</p>
                {/if    }
                <input
                    type="password"
                    placeholder="Wachtwoord"
                    bind:value={$LForm.password}
                    class="block w-full px-4 py-2 mb-4 border rounded border-gray-300"
                    required
                />
                {#if $LForm.errors.password}
                    <p class="text-red-500">{$LForm.errors.password}</p>
                {/if    }
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Inloggen</button>
                <p class="mt-4">
                    Heb je nog geen account?
                </p>
                <p>
                    <a href="/register" class="text-blue-500">Registreer</a> nu!
                </p>
            </form>
        </div>
    </main>
</div>
