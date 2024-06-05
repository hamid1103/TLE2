<script>
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
</script>

<!--header-->
<div class="overflow-hidden h-screen">
    <header class="header bg-[#40A0C1] text-white w-full h-12 flex justify-end items-center">
        <div class="black-circle relative before:content-[''] before:inline-block before:w-10 before:h-10 before:bg-black before:rounded-full before:mr-2.5"></div>
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
