<script>
    let subjects = ["wiskunde", "Maatschappijleer", "Engels"];
    let newSubject = "";
    let showInput = false;

    function addSubject() {
        if (newSubject !== "") {
            subjects = [...subjects, newSubject];
            newSubject = "";
            showInput = false;
        }
    }

</script>


<div class="overflow-hidden h-screen">
    <div class="flex"></div>
    <!--header-->
    <header class="header bg-[#40A0C1] text-white w-full h-12 flex justify-end items-center">
        <div class="black-circle relative before:content-[''] before:inline-block before:w-10 before:h-10 before:bg-black before:rounded-full before:mr-2.5"></div>
    </header>

    <div class="flex flex-wrap justify-center">
        {#each subjects as subject}
            <section class="w-40 h-40 bg-gray-500 rounded-square flex justify-center items-center m-2">
                <p>{subject}</p>
            </section>
        {/each}
        {#if showInput}
            <section class="w-40 h-40 bg-white rounded-square flex justify-center items-center m-2">
                <div class="flex flex-row justify-center items-center">
                    <input bind:value={newSubject} placeholder="Voer nieuw vak in" class="ml-24 border-black border-2"  />
                    <button on:click={addSubject} class="bg-[#40A0C1] text-white ">Submit</button>
                </div>
            </section>
        {:else}
            <section class="w-40 h-40 bg-gray-500 rounded-square flex justify-center items-center m-2" on:click={() => showInput = true}>
                <p>vak toevoegen</p>
            </section>
        {/if}
    </div>
</div>

