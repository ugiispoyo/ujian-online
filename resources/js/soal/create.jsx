import React, { useState, useEffect } from "react";
import ReactDOM from "react-dom/client";
import axios from "axios";
import { Button, Textarea, TextInput, Select } from "flowbite-react";

// Fungsi untuk mendapatkan query parameter dari URL
const getQueryParam = (param) => {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
};

const SoalForm = () => {
    const [soals, setSoals] = useState([]);
    const [pertanyaan, setPertanyaan] = useState("");
    const [jawaban, setJawaban] = useState([{ key: "", value: "" }]);
    const [jawabanBenar, setJawabanBenar] = useState("");
    const [idLomba, setIdLomba] = useState(null);

    // Ambil id_lomba dari query parameter saat komponen dimount
    useEffect(() => {
        const id = getQueryParam("id_lomba");
        setIdLomba(id);

        if (!id) {
            console.error("ID Lomba tidak ditemukan dalam URL!");
        } else {
            console.log(`ID Lomba: ${id}`);
        }
    }, []);

    const handleSubmit = async () => {
        const soal = {
            id: crypto.randomUUID(),
            pertanyaan,
            jawaban: jawaban.reduce((acc, curr) => {
                acc[curr.key] = curr.value;
                return acc;
            }, {}),
            jawaban_yang_benar: jawabanBenar,
        };

        try {
            const response = await axios.post("/api/soal/store", {
                id_lomba: idLomba,
                soal,
            });
            console.log(response.data.message); // Debug response dari server
            setSoals([...soals, soal]);
            setPertanyaan("");
            setJawaban([{ key: "", value: "" }]);
            setJawabanBenar("");
        } catch (error) {
            console.error(error.response?.data || error.message);
        }
    };

    return (
        <div className="p-6 bg-white rounded shadow-md">
            <h2 className="text-2xl font-bold mb-4">
                Tambah Soal
            </h2>

            {/* Pertanyaan */}
            <div className="mb-4">
                <label className="block mb-2 text-sm font-medium text-gray-700">
                    Pertanyaan
                </label>
                <Textarea
                    value={pertanyaan}
                    onChange={(e) => setPertanyaan(e.target.value)}
                    placeholder="Masukkan pertanyaan..."
                    rows={4}
                />
            </div>

            {/* Jawaban */}
            <div className="mb-4">
                <label className="block mb-2 text-sm font-medium text-gray-700">
                    Jawaban
                </label>
                {jawaban.map((item, index) => (
                    <div
                        key={index}
                        className="flex items-center space-x-4 mb-2"
                    >
                        <TextInput
                            placeholder={`Key ${index + 1}`}
                            value={item.key}
                            onChange={(e) =>
                                setJawaban(
                                    jawaban.map((j, i) =>
                                        i === index
                                            ? { ...j, key: e.target.value }
                                            : j
                                    )
                                )
                            }
                        />
                        <TextInput
                            placeholder="Value"
                            value={item.value}
                            onChange={(e) =>
                                setJawaban(
                                    jawaban.map((j, i) =>
                                        i === index
                                            ? { ...j, value: e.target.value }
                                            : j
                                    )
                                )
                            }
                        />
                        <Button
                            color="failure"
                            onClick={() =>
                                setJawaban(
                                    jawaban.filter((_, i) => i !== index)
                                )
                            }
                        >
                            Hapus
                        </Button>
                    </div>
                ))}
                {jawaban.length < 5 && (
                    <Button
                        color="teal"
                        onClick={() =>
                            setJawaban([...jawaban, { key: "", value: "" }])
                        }
                    >
                        Tambah Jawaban
                    </Button>
                )}
            </div>

            {/* Jawaban Benar */}
            <div className="mb-4">
                <label className="block mb-2 text-sm font-medium text-gray-700">
                    Jawaban Benar
                </label>
                <Select
                    value={jawabanBenar}
                    onChange={(e) => setJawabanBenar(e.target.value)}
                    required
                >
                    <option value="" disabled>
                        Pilih jawaban benar
                    </option>
                    {jawaban.map((item, index) => (
                        <option key={index} value={item.key}>
                            {item.key}
                        </option>
                    ))}
                </Select>
            </div>

            {/* Tombol Simpan */}
            <Button onClick={handleSubmit} className="mt-4" color="success">
                Simpan Soal
            </Button>
        </div>
    );
};

const reactApp = document.getElementById("soal-app");
const root = ReactDOM.createRoot(reactApp);
root.render(<SoalForm />);
