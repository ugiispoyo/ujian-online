import React, { useState, useEffect, useRef } from "react";
import ReactDOM from "react-dom/client";
import axios from "axios";
import { Button, TextInput, Select, Table, Pagination } from "flowbite-react";
import { useQuill } from "react-quilljs";

import "quill/dist/quill.snow.css";

// Fungsi untuk mendapatkan query parameter dari URL
const getQueryParam = (param) => {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
};

const SoalForm = () => {
    const [soals, setSoals] = useState([]);
    const [pertanyaan, setPertanyaan] = useState("");
    const [jawaban, setJawaban] = useState([""]);
    const [jawabanBenar, setJawabanBenar] = useState("");
    const [idLomba, setIdLomba] = useState(null);
    const [currentPage, setCurrentPage] = useState(1);
    const [itemsPerPage] = useState(10);

    const theme = "snow";
    const modules = {
        toolbar: [
            ["bold", "italic", "underline", "strike"],
            [{ header: [1, 2, 3, 4, 5, 6, false] }],
            [{ align: [] }],
            [{ list: "ordered" }, { list: "bullet" }],
            ["image", "link"],
        ],
    };
    const placeholder = "Tulis pertanyaan di sini...";
    const { quillRef, quill } = useQuill({ theme, modules, placeholder });

    useEffect(() => {
        if (quill) {
            // if (data) {
            // quill.root.innerHTML = data;
            // }
            quill.on("text-change", () => {
                const htmlText = quill.root.innerHTML;
                const textLength = quill.getLength();
                if (textLength > 1) {
                    setPertanyaan(htmlText);
                }
            });
            const quillAdd = quill.getModule("toolbar");
            quillAdd.addHandler("image", selectLocalImage);
        }
    }, [quill]);

    const insertImageToTextEditor = (url) => {
        const range = quill.getSelection();
        quill.insertEmbed(range.index, "image", url);
    };

    const selectLocalImage = () => {
        const input = document.createElement("input");
        input.setAttribute("type", "file");
        input.setAttribute("accept", "image/*");
        input.click();

        input.onchange = () => {
            const file = input?.files?.[0];
            uploadDescriptionImage(file);
        };
    };

    // Ambil id_lomba dari query parameter saat komponen dimount
    useEffect(() => {
        const id = getQueryParam("id_lomba");
        setIdLomba(id);
        if (id) {
            fetchSoals(id);
        } else {
            console.error("ID Lomba tidak ditemukan dalam URL!");
        }
    }, []);

    const fetchSoals = async (idLomba) => {
        try {
            const response = await axios.get(`/api/soal/${idLomba}`);
            setSoals(response.data?.[0]?.soal || []); // Muat soal dari database
        } catch (error) {
            console.error(
                "Gagal memuat soal:",
                error.response?.data || error.message
            );
        }
    };

    const uploadDescriptionImage = async (file) => {
        try {
            const formData = new FormData();
            formData.append("file", file);

            // Panggil API untuk upload gambar
            const response = await axios.post(
                "/api/soal/upload-image",
                formData,
                {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                }
            );

            // URL hasil upload
            const imageUrl = response.data.url;

            // Sisipkan gambar ke editor
            insertImageToTextEditor(imageUrl);
        } catch (error) {
            console.error("Error upload foto editor ", error);
        }
    };

    const handleSubmit = async () => {
        const soal = {
            id: crypto.randomUUID(),
            pertanyaan,
            jawaban,
            jawaban_yang_benar: jawabanBenar,
        };

        try {
            await axios.post("/api/soal/store", {
                id_lomba: idLomba,
                soal,
            });
            setSoals([...soals, soal]);
            quill.root.innerHTML = ""; // Reset editor
            setPertanyaan("");
            setJawaban([""]);
            setJawabanBenar("");
        } catch (error) {
            console.error(error.response?.data || error.message);
        }
    };

    const indexOfLastItem = currentPage * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    const currentSoals = soals.slice(indexOfFirstItem, indexOfLastItem);

    return (
        <div className="p-6 bg-white rounded shadow-md">
            <h2 className="text-2xl font-bold mb-4">Tambah Soal</h2>

            {/* Pertanyaan */}
            <div className="mb-4">
                <label className="block mb-2 text-sm font-medium text-gray-700">
                    Pertanyaan
                </label>
                <div ref={quillRef} />
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
                            placeholder={`Jawaban ${index + 1}`}
                            value={item}
                            onChange={(e) =>
                                setJawaban(
                                    jawaban.map((j, i) =>
                                        i === index ? e.target.value : j
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
                        onClick={() => setJawaban([...jawaban, ""])}
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
                        <option key={index} value={item}>
                            {item}
                        </option>
                    ))}
                </Select>
            </div>

            {/* Tombol Simpan */}
            <Button onClick={handleSubmit} className="mt-4" color="success">
                Simpan Soal
            </Button>

            {/* Daftar Soal */}
            <div className="mt-6">
                <h3 className="text-xl font-bold mb-4">Daftar Soal</h3>
                {soals.length > 0 ? (
                    <div className="overflow-x-auto">
                        <Table>
                            <Table.Head>
                                <Table.HeadCell>No</Table.HeadCell>
                                <Table.HeadCell>Pertanyaan</Table.HeadCell>
                                <Table.HeadCell>Jawaban</Table.HeadCell>
                                <Table.HeadCell>Jawaban Benar</Table.HeadCell>
                            </Table.Head>
                            <Table.Body>
                                {currentSoals.map((soal, index) => (
                                    <Table.Row key={index}>
                                        <Table.Cell>
                                            {indexOfFirstItem + index + 1}
                                        </Table.Cell>
                                        <Table.Cell>
                                            <div className="overflow-auto max-h-[150px]">
                                                <div
                                                    dangerouslySetInnerHTML={{
                                                        __html: soal.pertanyaan,
                                                    }}
                                                ></div>
                                            </div>
                                        </Table.Cell>
                                        <Table.Cell>
                                            <ul>
                                                {soal.jawaban.map((item, i) => (
                                                    <li key={i}>
                                                        {String.fromCharCode(
                                                            97 + i
                                                        )}
                                                        . {item}
                                                    </li>
                                                ))}
                                            </ul>
                                        </Table.Cell>
                                        <Table.Cell>
                                            {soal.jawaban.map((item, i) => (
                                                <React.Fragment key={i}>
                                                    {soal.jawaban_yang_benar ===
                                                        item && (
                                                        <span>
                                                            {String.fromCharCode(
                                                                97 + i
                                                            )}
                                                            . {item}
                                                        </span>
                                                    )}
                                                </React.Fragment>
                                            ))}
                                        </Table.Cell>
                                    </Table.Row>
                                ))}
                            </Table.Body>
                        </Table>

                        <Pagination
                            currentPage={currentPage}
                            totalPages={Math.ceil(soals.length / itemsPerPage)}
                            onPageChange={(page) => setCurrentPage(page)}
                        />
                    </div>
                ) : (
                    <div className="text-center text-gray-500">
                        Belum ada soal yang diinput sebelumnya.
                    </div>
                )}
            </div>
        </div>
    );
};

const reactApp = document.getElementById("soal-app");
const root = ReactDOM.createRoot(reactApp);
root.render(<SoalForm />);
