<?php

/**
 * @param array $reportedJSON
 * @param int $numberExpectedErrors
 *
 * @throws RuntimeException if assertion is false
 */
function assertNumberTotalErrors(array $reportedJSON, int $numberExpectedErrors)
{
    $totalReportedErrors = $reportedJSON['totals']['file_errors'];

    if ($totalReportedErrors !== $numberExpectedErrors) {
        throw new RuntimeException(sprintf('Expected %d reported errors, got %d', $numberExpectedErrors, $totalReportedErrors));
    }
}

/**
 * @param array $reportedJSON
 * @param string $givenFileName
 * @param string $errorMessage
 *
 * @throws RuntimeException if assertion is false
 */
function assertFileHasErrorMessage(array $reportedJSON, string $givenFileName, string $errorMessage)
{
    foreach ($reportedJSON['files'] as $fileName => $fileData) {
        if (basename($fileName) === $givenFileName) {
            foreach ($fileData['messages'] as $errors) {
                if ($errors['message'] === $errorMessage) {
                    return;
                }
            }

            throw new RuntimeException(sprintf('Could not find error message %s in given PHPStan report', $errorMessage));
        }
    }

    throw new RuntimeException(sprintf('Could not find file %s in given PHPStan report', $fileName));
}
