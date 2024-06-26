<script>
    import axios from "axios";

    export let board, questions, boardRequest;
    console.log(board)
    console.log(questions)
    console.log(boardRequest)

    const logout = async () => {
        try {
            // Verstuur een POST-verzoek naar de logout route
            await axios.post('/logout');
            // Na succesvolle logout, redirect naar de login pagina
            window.location.href = '/login';
        } catch (error) {
            console.error('Error during logout:', error);
        }
    }
</script>

<style>
    .custom-circle::before {
        content: '';
        display: inline-block;
        width: 2.5rem; /* 10 * 0.25rem */
        height: 2.5rem;
        background-image: url('../../img/login.png');
        background-size: cover;
        background-position: center;
        border-radius: 50%;
        margin-right: 0.625rem; /* 2.5 * 0.25rem */
        background-color: white; /* Fallback in case the image doesn't load */
    }
</style>

<div class="h-screen bg-[#F4FFFE]">
    <header class="bg-[#40A0C1] text-white w-full h-12 flex justify-end items-center">
        <button
            class="black-circle relative custom-circle"
            on:click={logout}
            title="Klik om uit te loggen"
            aria-label="Uitloggen">
        </button>
    </header>

    <div class="text-center pt-2">
        <h1 class="text-4xl mb-5">Breng jullie vragen vanuit de chat naar dit bord!</h1>
        <h2 class="text-2xl mb-10">Code: {boardRequest.rngcode}</h2>
    </div>

    <div class="flex flex-wrap justify-center">
<!--        <div class="w-5/12 bg-[#C4F0FF] rounded-md flex justify-center items-center m-2 p-2">-->
<!--            Hoe lang duurt het voordat de zon de aarde bereikt?-->
<!--        </div>-->
        {#each questions as question}
            <div class="w-5/12 bg-[#C4F0FF] rounded-md flex justify-center items-center m-2 p-2">
                {question.Content}
            </div>
        {/each}
    </div>
</div>
