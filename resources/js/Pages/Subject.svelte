<script>
    import axios from "axios";

    let subjects = JSON.parse(localStorage.getItem('subjects')) || ["Wiskunde", "Maatschappijleer", "Engels"];
    let newSubject = "";
    let showInput = false;

    function addSubject() {
        if (newSubject !== "") {
            subjects = [...subjects, newSubject];
            localStorage.setItem('subjects', JSON.stringify(subjects));
            newSubject = "";
            showInput = false;
        }
    }

    function removeSubject(subjectToRemove) {
        subjects = subjects.filter(subject => subject !== subjectToRemove);
        localStorage.setItem('subjects', JSON.stringify(subjects));
    }

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

<!--header-->
<div class="overflow-hidden h-screen">
    <header class="header bg-[#40A0C1] text-white w-full h-12 flex justify-end items-center">
        <button
            class="black-circle relative custom-circle"
            on:click={logout}
            title="Klik om uit te loggen"
            aria-label="Uitloggen">
        </button>
    </header>

    <h1 class="text-center text-5xl pb-5 pt-4">Vakken</h1>
    <div>
    <div class="flex flex-wrap justify-center">
        {#each subjects as subject}
            <a href="/" class=" w-32 h-32 md:w-40 md:h-40 bg-[#C4F0FF] rounded-square flex justify-center items-center m-2 md:mr-20 relative">
                <div class="flex flex-col w-full h-full justify-between items-center">
                    <div class="flex justify-end w-full p-2">
                        <div class="cursor-pointer" on:click|stopPropagation={(event) => {event.preventDefault(); removeSubject(subject);}}>X</div>
                    </div>
                    <div class="flex justify-center items-center flex-grow mb-10">
                        <p>{subject}</p>
                    </div>
                </div>
            </a>
        {/each}
        {#if showInput}
            <section class="w-32 h-32 md:w-40 md:h-40 bg-white rounded-square flex justify-center items-center m-2">
                <div class="flex flex-row justify-center items-center">
                    <input bind:value={newSubject} placeholder="Voer nieuw vak in" class="ml-24 border-black border-2"/>
                    <button on:click={addSubject} class="bg-[#40A0C1] text-white ">Submit</button>
                </div>
            </section>
        {:else}
            <section class="w-32 h-32 md:w-40 md:h-40 bg-[#C4F0FF] rounded-square flex justify-center items-center m-2 md:mr-20"
                     on:click={() => showInput = true}>
                <p>Vak toevoegen</p>
            </section>
        {/if}
    </div>
</div>
</div>
