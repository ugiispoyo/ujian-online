import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom/client";
import axios from "axios";

const Tes = () => {
    const [soalList, setSoalList] = useState([]);
    const [currentIndex, setCurrentIndex] = useState(0);
    const [jawaban, setJawaban] = useState({});
    const [loading, setLoading] = useState(true);
    const [errorMessage, setErrorMessage] = useState("");

    const roomId = window.location.pathname.split("/")[2];

    useEffect(() => {
        axios
            .get(`/api/room-tes/${roomId}`)
            .then((response) => {
                setSoalList(response.data.soal);
                const savedJawaban = response.data.room.soal_terjawab || [];

                // Konversi array ke object berbasis id soal
                const jawabanMap = {};
                savedJawaban.forEach((item) => {
                    jawabanMap[item.id] = item.jawaban_di_pilih;
                });

                setJawaban(jawabanMap);

                setLoading(false);
            })
            .catch((error) => console.error("Gagal mengambil soal:", error));
    }, []);

    const saveJawabanToServer = (updatedJawaban) => {
        const jawabanArray = Object.keys(updatedJawaban).map((id) => {
            const soal = soalList.find((s) => s.id === id);
            return {
                id: id,
                pertanyaan: soal ? soal.pertanyaan : "",
                jawaban_di_pilih: updatedJawaban[id],
            };
        });

        axios
            .post(`/api/room-tes/${roomId}/update-jawaban`, {
                jawaban: jawabanArray,
            })
            .catch((error) => console.error("Gagal menyimpan jawaban:", error));
    };

    const handleJawabanChange = (soalId, value) => {
        setJawaban((prevJawaban) => {
            const updatedJawaban = { ...prevJawaban, [soalId]: value };
            saveJawabanToServer(updatedJawaban);
            return updatedJawaban;
        });
        setErrorMessage("");
    };

    const handleNext = () => {
        if (!jawaban[soalList[currentIndex].id]) {
            setErrorMessage("Silakan pilih jawaban sebelum melanjutkan.");
            return;
        }
        setCurrentIndex((prevIndex) => prevIndex + 1);
    };

    const handlePrevious = () => {
        setErrorMessage("");
        if (currentIndex > 0) {
            setCurrentIndex((prevIndex) => prevIndex - 1);
        }
    };

    const handleNavigateToSoal = (index) => {
        setCurrentIndex(index);
    };

    const handleSubmit = () => {
        if (!jawaban[soalList[currentIndex].id]) {
            setErrorMessage("Silakan pilih jawaban sebelum mengumpulkan.");
            return;
        }

        saveJawabanToServer(jawaban);
        alert("Jawaban berhasil dikirim");
    };

    if (loading) return <p>Loading...</p>;

    return (
        <div className="max-w-full mx-auto p-6 bg-white shadow-lg rounded-lg">
            <h1 className="text-xl font-bold mb-4">Room Ujian</h1>

            {/* Denah Soal */}
            <div className="flex flex-wrap gap-2 mb-4">
                {soalList.map((soal, index) => (
                    <button
                        key={soal.id}
                        className={`w-10 h-10 flex items-center justify-center border rounded-md ${
                            jawaban[soal.id]
                                ? "bg-green-500 text-white"
                                : "bg-gray-300 text-black"
                        } ${
                            currentIndex === index
                                ? "border-2 border-yellow-400"
                                : "border-gray-400"
                        }`}
                        onClick={() => handleNavigateToSoal(index)}
                    >
                        {index + 1}
                    </button>
                ))}
            </div>

            {soalList.length > 0 ? (
                <div>
                    <div className="mb-4">
                        <p className="font-semibold">
                            {currentIndex + 1}.{" "}
                            <span
                                dangerouslySetInnerHTML={{
                                    __html: soalList[currentIndex].pertanyaan,
                                }}
                            />
                        </p>
                    </div>
                    <div className="mb-4">
                        {soalList[currentIndex].jawaban.map((option, idx) => (
                            <label key={idx} className="flex items-center mt-2">
                                <input
                                    type="radio"
                                    name={`jawaban-${soalList[currentIndex].id}`}
                                    value={option}
                                    className="mr-2"
                                    checked={
                                        jawaban[soalList[currentIndex].id] ===
                                        option
                                    }
                                    onChange={() =>
                                        handleJawabanChange(
                                            soalList[currentIndex].id,
                                            option
                                        )
                                    }
                                />
                                <span
                                    dangerouslySetInnerHTML={{ __html: option }}
                                />
                            </label>
                        ))}
                    </div>

                    {errorMessage && (
                        <p className="text-red-500">{errorMessage}</p>
                    )}

                    <div className="flex justify-between mt-4">
                        <button
                            onClick={handlePrevious}
                            className={`px-4 py-2 bg-gray-400 text-white rounded-md ${
                                currentIndex === 0
                                    ? "opacity-50 cursor-not-allowed"
                                    : "hover:bg-gray-500"
                            }`}
                            disabled={currentIndex === 0}
                        >
                            Sebelumnya
                        </button>

                        {currentIndex < soalList.length - 1 ? (
                            <button
                                onClick={handleNext}
                                className={`px-4 py-2 rounded-md text-white ${
                                    jawaban[soalList[currentIndex].id]
                                        ? "bg-blue-600 hover:bg-blue-700"
                                        : "bg-gray-400 cursor-not-allowed"
                                }`}
                                disabled={!jawaban[soalList[currentIndex].id]}
                            >
                                Selanjutnya
                            </button>
                        ) : (
                            <button
                                onClick={handleSubmit}
                                className={`px-4 py-2 rounded-md text-white ${
                                    jawaban[soalList[currentIndex].id]
                                        ? "bg-green-600 hover:bg-green-700"
                                        : "bg-gray-400 cursor-not-allowed"
                                }`}
                                disabled={!jawaban[soalList[currentIndex].id]}
                            >
                                Kumpulkan Jawaban
                            </button>
                        )}
                    </div>
                </div>
            ) : (
                <p className="text-gray-600">Tidak ada soal tersedia</p>
            )}
        </div>
    );
};

const reactApp = document.getElementById("root-test");
const root = ReactDOM.createRoot(reactApp);
root.render(<Tes />);
