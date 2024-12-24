import React, { useState, useEffect, useRef } from "react";
import ReactDOM from "react-dom/client";
import axios from "axios";
import { Button, Select, Table, Pagination } from "flowbite-react";
import Quill from "quill";

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

    const pertanyaanRef = useRef(null);
    const jawabanRefs = useRef([]); // Ref untuk menyimpan DOM container dari editor jawaban
    const quillInstances = useRef([]); // Ref untuk menyimpan instance Quill

    const toolbarOptions = [
        ["bold", "italic", "underline", "strike"],
        [{ header: [1, 2, 3, 4, 5, 6, false] }],
        [{ align: [] }],
        [{ list: "ordered" }, { list: "bullet" }],
        ["image", "link"],
    ];

    // Ambil id_lomba dari query parameter
    useEffect(() => {
        const id = getQueryParam("id_lomba");
        setIdLomba(id);
        if (id) {
            fetchSoals(id);
        }
    }, []);

    // Inisialisasi Quill untuk editor pertanyaan
    useEffect(() => {
        const quill = new Quill(pertanyaanRef.current, {
            theme: "snow",
            modules: {
                toolbar: toolbarOptions,
            },
        });

        quill.on("text-change", () => {
            const html = quill.root.innerHTML;
            setPertanyaan(html);
        });

        quill
            .getModule("toolbar")
            .addHandler("image", () => selectLocalImage(quill));
    }, []);

    // Fungsi upload gambar
    const uploadImage = async (file, quill) => {
        try {
            const formData = new FormData();
            formData.append("file", file);

            const response = await axios.post(
                "/api/soal/upload-image",
                formData,
                {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                }
            );

            const imageUrl = response.data.url;
            const range = quill.getSelection();
            quill.insertEmbed(range.index, "image", imageUrl);
        } catch (error) {
            console.error("Error upload foto editor", error);
        }
    };

    const selectLocalImage = (quill) => {
        const input = document.createElement("input");
        input.setAttribute("type", "file");
        input.setAttribute("accept", "image/*");
        input.click();

        input.onchange = () => {
            const file = input?.files?.[0];
            if (file) {
                uploadImage(file, quill);
            }
        };
    };

    // Inisialisasi Quill untuk setiap jawaban
    useEffect(() => {
        initializeJawabanEditors();
    }, [jawaban]);

    const fetchSoals = async (idLomba) => {
        try {
            const response = await axios.get(`/api/soal/${idLomba}`);
            setSoals(response.data?.[0]?.soal || []);
        } catch (error) {
            console.error(
                "Gagal memuat soal:",
                error.response?.data || error.message
            );
        }
    };

    const handleSubmit = async () => {
        try {
            // Validasi Pertanyaan
            const sanitizedPertanyaan =
                typeof pertanyaan === "string" && pertanyaan.trim()
                    ? pertanyaan.trim()
                    : "";

            // Validasi Jawaban
            const sanitizedJawaban = jawaban.map((j) => {
                if (typeof j === "string" && j.trim()) {
                    return j.trim();
                } else {
                    return ""; // Ganti dengan string kosong jika nilai tidak valid
                }
            });

            // Validasi apakah ada jawaban kosong
            if (sanitizedJawaban.some((j) => j === "")) {
                alert("Semua jawaban harus diisi!");
                return;
            }

            // Validasi apakah jawaban benar valid
            if (
                typeof jawabanBenar === "undefined" ||
                !sanitizedJawaban[jawabanBenar]
            ) {
                alert("Pilih jawaban benar yang valid!");
                return;
            }

            // Siapkan data soal
            const soal = {
                id: crypto.randomUUID(),
                pertanyaan: sanitizedPertanyaan,
                jawaban: sanitizedJawaban,
                jawaban_yang_benar: sanitizedJawaban[jawabanBenar],
            };

            // Simpan ke server
            await axios.post("/api/soal/store", {
                id_lomba: idLomba,
                soal,
            });

            window.location.reload();
        } catch (error) {
            console.error(
                "Error saat menyimpan soal:",
                error.response?.data || error.message
            );
        }
    };

    const initializeJawabanEditors = () => {
        jawaban.forEach((_, index) => {
            if (!quillInstances.current[index]) {
                const editorRef = jawabanRefs.current[index];
                if (editorRef) {
                    const quill = new Quill(editorRef, {
                        theme: "snow",
                        modules: {
                            toolbar: toolbarOptions,
                        },
                    });

                    quill.on("text-change", () => {
                        const html = quill.root.innerHTML || ""; // Tambahkan validasi di sini
                        const updatedJawaban = [...jawaban];
                        updatedJawaban[index] = html;
                        setJawaban(updatedJawaban);
                    });

                    quill
                        .getModule("toolbar")
                        .addHandler("image", () => selectLocalImage(quill));

                    quillInstances.current[index] = quill;
                }
            }
        });
    };

    const addJawaban = () => {
        if (jawaban.length < 5) {
            setJawaban([...jawaban, ""]);
            jawabanRefs.current.push(null);
            setTimeout(() => initializeJawabanEditors(), 0); // Pastikan editor diinisialisasi ulang
        }
    };

    const removeJawaban = (index) => {
        // Ambil instance Quill yang akan dihapus
        const instance = quillInstances.current[index];
        if (instance) {
            // Hapus event listener dan DOM editor
            instance.off("text-change");
            instance.root.innerHTML = "";
            instance.container.parentNode.removeChild(instance.container);
        }

        // Hapus item dari array Quill instances dan jawabanRefs
        quillInstances.current.splice(index, 1);
        jawabanRefs.current.splice(index, 1);

        // Perbarui state jawaban
        setJawaban((prevJawaban) => prevJawaban.filter((_, i) => i !== index));
    };

    const indexOfLastItem = currentPage * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    const currentSoals = soals.slice(indexOfFirstItem, indexOfLastItem);

    return (
        <div className="p-6 bg-white rounded shadow-md">
            <h2 className="text-2xl font-bold mb-4">Tambah Soal</h2>

            {/* Pertanyaan */}
            <div className="mb-4">
                <label className="block mb-2 text-lg font-bold text-gray-700">
                    Pertanyaan
                </label>
                <div ref={pertanyaanRef} />
            </div>

            {/* Jawaban */}
            <div className="mb-4">
                <label className="block mb-2 text-lg font-bold text-gray-700">
                    Jawaban
                </label>
                {jawaban.map((_, index) => (
                    <div key={index} className="mb-3 flex gap-2">
                        <span>{String.fromCharCode(97 + index)}</span>
                        <div className="w-full flex flex-col">
                            <div
                                ref={(ref) =>
                                    (jawabanRefs.current[index] = ref)
                                }
                            />
                            <div className="flex justify-end w-full">
                                {index + 1 === jawaban.length && (
                                    <Button
                                        color="failure"
                                        className="mt-2 max-w-[100px]"
                                        onClick={() => removeJawaban(index)}
                                    >
                                        Hapus
                                    </Button>
                                )}
                            </div>
                        </div>
                    </div>
                ))}
                {jawaban.length < 5 && (
                    <Button color="teal" onClick={addJawaban}>
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
                >
                    <option value="" disabled>
                        Pilih jawaban benar
                    </option>
                    {jawaban.map((_, index) => (
                        <option key={index} value={index}>
                            Jawaban {index + 1}
                        </option>
                    ))}
                </Select>
            </div>

            <Button onClick={handleSubmit} color="success">
                Simpan Soal
            </Button>

            {/* Daftar Soal */}
            <div className="mt-6">
                <h3 className="text-xl font-bold mb-4">Daftar Soal</h3>
                {soals.length > 0 ? (
                    <div className="overflow-x-auto">
                        <Table className="w-full overflow-x-auto">
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
                                            <div className="max-h-[150px] overflow-y-auto">
                                                <div
                                                    dangerouslySetInnerHTML={{
                                                        __html: soal.pertanyaan,
                                                    }}
                                                ></div>
                                            </div>
                                        </Table.Cell>
                                        <Table.Cell>
                                            <div className="max-h-[150px] overflow-y-auto">
                                                {soal.jawaban.map((item, i) => (
                                                    <div
                                                        className="flex gap-2"
                                                        key={i}
                                                    >
                                                        <span>
                                                            {String.fromCharCode(
                                                                97 + i
                                                            )}
                                                            .
                                                        </span>
                                                        <div
                                                            key={i}
                                                            dangerouslySetInnerHTML={{
                                                                __html: item,
                                                            }}
                                                        ></div>
                                                    </div>
                                                ))}
                                            </div>
                                        </Table.Cell>
                                        <Table.Cell>
                                            <div className="max-h-[150px] overflow-y-auto">
                                                {soal.jawaban.map((item, i) => (
                                                    <React.Fragment key={i}>
                                                        {soal.jawaban_yang_benar ===
                                                            item && (
                                                            <div
                                                                className="flex gap-2"
                                                                key={i}
                                                            >
                                                                <span>
                                                                    {String.fromCharCode(
                                                                        97 + i
                                                                    )}
                                                                    .
                                                                </span>
                                                                <div
                                                                    key={i}
                                                                    dangerouslySetInnerHTML={{
                                                                        __html: item,
                                                                    }}
                                                                ></div>
                                                            </div>
                                                        )}
                                                    </React.Fragment>
                                                ))}
                                            </div>
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
