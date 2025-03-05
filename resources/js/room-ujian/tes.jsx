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
                setJawaban(
                    response.data.room.soal_terjawab
                        ? JSON.parse(response.data.room.soal_terjawab)
                        : {}
                );
                setLoading(false);
            })
            .catch((error) => console.error("Gagal mengambil soal:", error));
    }, []);

    const saveJawabanToServer = (updatedJawaban) => {
        axios
            .post(`/api/room-tes/${roomId}/update-jawaban`, {
                jawaban: updatedJawaban,
            })
            .catch((error) => console.error("Gagal menyimpan jawaban:", error));
    };

    const handleJawabanChange = (index, value) => {
        const updatedJawaban = {
            ...jawaban,
            [index]: value,
        };
        setJawaban(updatedJawaban);
        setErrorMessage(""); // Hapus pesan error jika peserta sudah memilih jawaban

        // Simpan jawaban ke server setiap kali ada perubahan
        saveJawabanToServer(updatedJawaban);
    };

    const handleNext = () => {
        if (!jawaban.hasOwnProperty(currentIndex)) {
            setErrorMessage("Silakan pilih jawaban sebelum melanjutkan.");
            return;
        }
        setCurrentIndex(currentIndex + 1);
    };

    const handlePrevious = () => {
        setErrorMessage(""); // Hapus error jika kembali ke soal sebelumnya
        if (currentIndex > 0) {
            setCurrentIndex(currentIndex - 1);
        }
    };

    const handleSubmit = () => {
        if (!jawaban.hasOwnProperty(currentIndex)) {
            setErrorMessage("Silakan pilih jawaban sebelum mengumpulkan.");
            return;
        }

        axios
            .post(`/api/room-tes/${roomId}/submit`, { jawaban })
            .then(() => alert("Jawaban berhasil dikirim"))
            .catch((error) => console.error("Gagal mengirim jawaban:", error));
    };

    if (loading) return <p>Loading...</p>;

    return (
        <div className="max-w-full mx-auto p-6 bg-white shadow-lg rounded-lg">
            <h1 className="text-xl font-bold mb-4">Room Ujian</h1>
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
                                    name={`jawaban-${currentIndex}`}
                                    value={option}
                                    className="mr-2"
                                    checked={jawaban[currentIndex] === option}
                                    onChange={() =>
                                        handleJawabanChange(
                                            currentIndex,
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

                    {/* Pesan error jika belum memilih jawaban */}
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
                                    jawaban.hasOwnProperty(currentIndex)
                                        ? "bg-blue-600 hover:bg-blue-700"
                                        : "bg-gray-400 cursor-not-allowed"
                                }`}
                                disabled={!jawaban.hasOwnProperty(currentIndex)}
                            >
                                Selanjutnya
                            </button>
                        ) : (
                            <button
                                onClick={handleSubmit}
                                className={`px-4 py-2 rounded-md text-white ${
                                    jawaban.hasOwnProperty(currentIndex)
                                        ? "bg-green-600 hover:bg-green-700"
                                        : "bg-gray-400 cursor-not-allowed"
                                }`}
                                disabled={!jawaban.hasOwnProperty(currentIndex)}
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
