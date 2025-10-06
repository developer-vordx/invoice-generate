<?php

namespace App\Services\Auth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IDVerificationService
{
    protected string $apiUrl;
    protected string $secretKey;

    public function __construct()
    {
        $this->apiUrl = 'https://dvs2.idware.net/api/v4/verify';
        $this->secretKey = config('services.idware.secret');
    }

    public function verify(Request $request): array
    {
        try {
            $validated = $request->validated();
            $payload = [
                'documentType' => (int) $validated['documentType'],
                'frontImageBase64' => $this->fileToBase64($request->file('frontImage')),
                'backOrSecondImageBase64' => $request->hasFile('backImage') ? $this->fileToBase64($request->file('backImage')) : null,
                'faceImageBase64' => $request->hasFile('faceImage') ? $this->fileToBase64($request->file('faceImage')) : null,
                'ssn' => $validated['ssn'] ?? null,
                'overriddenSettings' => [
                    'isOCREnabled' => true,
                    'isBackOrSecondImageProcessingEnabled' => false,
                    'isFaceMatchEnabled' => true,
                    'isExternalOFACWatchlistEnabled' => true,
                ],
                'metadata' => [
                    'captureMethod' => 0, // File Upload
                    'userAgent' => $request->userAgent(),
                ]
            ];

            $response = Http::withToken($this->secretKey)
                ->acceptJson()
                ->post($this->apiUrl, $payload);

            if ($response->successful()) {
                $this->saveVerification($response->json());
                return [
                    'success' => true,
                    'message' => $response['message'] ?? 'Verification successful.',
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'message' => $response->json()['message'] ?? 'API error.',
                'status' => $response->status()
            ];
        } catch (\Exception $e) {
            Log::error('ID Verification failed: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage()
            ];
        }
    }

    private function fileToBase64($file)
    {
        return base64_encode(file_get_contents($file->getRealPath()));
    }

    private function saveVerification($response)
    {
        try {
            $document = $response['document'] ?? [];
            $faceMatch = $response['faceMatchVerificationResult'] ?? [];
            $antiSpoof = $response['antiSpoofingVerificationResult'] ?? [];
            $docVerification = $response['documentVerificationResult'] ?? [];

            $verification = UserVerification::create([
                'first_name' => $document['firstName'] ?? null,
                'full_name' => $document['fullName'] ?? null,
                'family_name' => $document['familyName'] ?? null,
                'maiden_name' => $document['maidenName'] ?? null,
                'middle_name' => $document['middleName'] ?? null,
                'dob' => $document['dob'] ?? null,
                'gender' => $document['gender'] ?? null,
                'place_of_birth' => $document['placeOfBirth'] ?? null,
                'document_number' => $document['id'] ?? null,
                'id_type' => $document['idType'] ?? null,
                'issued' => $document['issued'] ?? null,
                'issued_by' => $document['issuedBy'] ?? null,
                'postal_box' => $document['postalBox'] ?? null,
                'state' => $document['state'] ?? null,
                'weight' => $document['weight'] ?? null,
                'zip' => $document['zip'] ?? null,
                'user_id' => auth()->id(), // Assuming you're saving it for the logged-in user
                'race' => $document['race'] ?? null,
                'restriction_code' => $document['restrictionCode'] ?? null,
                'personal_number' => $document['personalNumber'] ?? null,
                'ssn' => $document['ssn'] ?? null,
                'suffix' => $document['suffix'] ?? null,
                'abbr3_country' => $document['abbr3Country'] ?? null,
                'abbr_country' => $document['abbrCountry'] ?? null,
                'address' => $document['address'] ?? null,
                'city' => $document['city'] ?? null,
                'class' => $document['class'] ?? null,
                'country' => $document['country'] ?? null,
                'status' => 'approved',
                'document_confidence_scores' => $docVerification['documentConfidence'],
                'face_match_confidence' => $faceMatch['faceMatchConfidence'] ?? null,
                'anti_spoofing_face_image_confidence' => $antiSpoof['antiSpoofingFaceImageConfidence'] ?? null,
                'is_document_expired' => $docVerification['isDocumentExpired'] ?? null,
                'is_ocr_success' => $docVerification['isOcrSuccess'] ?? null,
                'document_confidence' => $docVerification['documentConfidence'] ?? null,
            ]);

            $user = Auth::user();
             $user->update([
                 'country' => $document['country'] ?? null,
                 'city' => $document['city'] ?? null,
                 'address' => $document['address'] ?? null,
                 'state' => $document['state'] ?? null,
                 'zip' => $document['zip'] ?? null,
                 'country_code' => $document['abbr3Country'] ?? null,
             ]);

            return $verification;
        } catch (\Exception $exception) {

            return false;
        }
    }

}
