<?php
require_once("connect.php");


class Person
{

    /**
     * @param $id
     * @param $locale
     * @return array
     */
    public function getInfo($id, $locale)
    {
        $result = array();
        $result['person'] = $this->getPerson($id, $locale);
        $result['resume'] = $this->getResume($id, $locale);
        $result['portfolio'] = $this->getPortfolio($id, $locale);

        return $result;
    }


    /**
     * @param $id
     * @param $locale
     * @return array
     */
    private function getResume($id, $locale)
    {
        $output = array();

        $output['profile'] = $this->getProfileInfo($id, $locale);
        $output['contact'] = $this->getContactInfo($id, $locale);
        $output['personal'] = $this->getPersonalInfo($id, $locale);
        $output['work'] = $this->getWorkInfo($id, $locale);
        $output['social_networks'] = $this->getSocialNetworks($id);
        $output['education'] = $this->getEducationInfo($id, $locale);
        $output['companies'] = $this->getCompaniesInfo($id, $locale);
        $output['projects'] = $this->getProjectsInfo($id, $locale);
        $output['skills'] = $this->getSkillsInfo($id);

        return $output;
    }

    /**
     * @param $id
     * @param $locale
     * @return array
     */
    private function getPerson($id, $locale)
    {
        $output = array();
        $connectObject = new Connection;
        $conn = $connectObject->connectToDatabase();

        $sql = "CALL sp_select_person('$id','$locale')";
        $resp = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($resp)) {
            $output = $row;
        }
        mysqli_close($conn);
        return $output;
    }

    /**
     * @param $id
     * @param $locale
     * @return array|string[]
     */
    private function getProfileInfo($id, $locale)
    {
        $output = array();
        $connectObject = new Connection;
        $conn = $connectObject->connectToDatabase();

        $sql = "CALL sp_select_profile_info('$id','$locale')";

        $resp = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($resp)) {
            $output = $row;
        }

        mysqli_close($conn);
        return $output;
    }

    /**
     * @param $id
     * @param $locale
     * @return array|string[]
     */
    private function getContactInfo($id, $locale)
    {
        $output = array();
        $connectObject = new Connection;
        $conn = $connectObject->connectToDatabase();

        $sql = "CALL sp_select_contact_info('$id','$locale')";
        $resp = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($resp)) {
            $output = $row;
        }

        mysqli_close($conn);
        return $output;
    }

    /**
     * @param $id
     * @param $locale
     * @return array|string[]
     */
    private function getPersonalInfo($id, $locale)
    {
        $output = array();
        $connectObject = new Connection;
        $conn = $connectObject->connectToDatabase();
        $sql = "CALL sp_select_personal_info('$id','$locale')";

        $resp = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($resp)) {
            $output = $row;
        }

        mysqli_close($conn);
        return $output;
    }

    /**
     * @param $id
     * @param $locale
     * @return array
     */
    private function getWorkInfo($id, $locale)
    {
        $output = array();
        $connectObject = new Connection;
        $conn = $connectObject->connectToDatabase();

        $sql = "CALL sp_select_work_info('$id','$locale')";

        $resp = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($resp)) {

            $output['status'] = $row['status'];
            $output['type'] = $row['type'];
            $output['cities'] = explode('*', $row['cities']);
        }

        mysqli_close($conn);
        return $output;
    }

    /**
     * @param $id
     * @return array
     */
    private function getSocialNetworks($id)
    {
        $output = array();
        $connectObject = new Connection;
        $conn = $connectObject->connectToDatabase();
        $sql = "CALL sp_select_social_networks_info('$id')";

        $resp = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($resp)) {
            $output[] = $row;
        }

        mysqli_close($conn);
        return $output;
    }

    /**
     * @param $id
     * @param $locale
     * @return array
     */
    private function getEducationInfo($id, $locale)
    {
        $output = array();
        $connectObject = new Connection;
        $conn = $connectObject->connectToDatabase();
        $sql = "CALL sp_select_education_info('$id','$locale')";
        $resp = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($resp)) {
            $output[] = $row;
        }

        mysqli_close($conn);
        return $output;
    }

    /**
     * @param $id
     * @param $locale
     * @return array
     */
    private function getCompaniesInfo($id, $locale)
    {
        $output = array();
        $connectObject = new Connection;
        $conn = $connectObject->connectToDatabase();
        $sql = "CALL sp_select_companies_info('$id', '$locale')";

        $resp = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($resp)) {
            $output[] = $row;
        }

        mysqli_close($conn);
        return $output;
    }

    /**
     * @param $id
     * @param $locale
     * @return array
     */
    private function getProjectsInfo($id, $locale)
    {
        $output = array();
        $connectObject = new Connection;
        $conn = $connectObject->connectToDatabase();

        $sql = "CALL sp_select_projects_info('$id', '$locale')";

        $resp = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($resp)) {
            $output[] = $row;
        }

        mysqli_close($conn);
        return $output;
    }

    private function getSkillsInfo($id)
    {
        $output = array();
        $output['languages'] = $this->getLanguageSkills($id);
        $output['tech'] = $this->getTechSkills($id);
        $output['prog'] = $this->getProgrammingSkills($id);
        return $output;
    }

    /**
     * @param $id
     * @return array
     */
    private function getLanguageSkills($id)
    {
        $output = array();
        $connectObject = new Connection;
        $conn = $connectObject->connectToDatabase();

        $sql = "CALL sp_select_lang_skills_info('$id')";

        $resp = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($resp)) {
            $output[] = $row;
        }

        mysqli_close($conn);
        return $output;
    }

    /**
     * @param $id
     * @return array
     */
    private function getTechSkills($id)
    {
        $output = array();
        $connectObject = new Connection;
        $conn = $connectObject->connectToDatabase();

        $sql = "CALL sp_select_tech_skills_info('$id')";

        $resp = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($resp)) {
            $output[] = $row;
        }

        mysqli_close($conn);
        return $output;
    }

    /**
     * @param $id
     * @return array
     */
    private function getProgrammingSkills($id)
    {
        $output = array();
        $connectObject = new Connection;
        $conn = $connectObject->connectToDatabase();

        $sql = "CALL sp_select_prog_skills_info('$id')";
        $resp = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($resp)) {
            $output[] = $row;
        }

        mysqli_close($conn);
        return $output;
    }

    /**
     * @param $id
     * @param $locale
     * @return array
     */
    private function getPortfolio($id, $locale)
    {
        $output = array();
        $output['android'] = $this->getAndroidPortfolio($id, $locale);
        $output['flutter'] = $this->getFlutterPortfolio($id, $locale);
        return $output;
    }

    /**
     * @param $id
     * @param $locale
     * @return array
     */
    private function getAndroidPortfolio($id, $locale)
    {
        $output = array();
        $connectObject = new Connection;
        $conn = $connectObject->connectToDatabase();

        $sql = "CALL sp_select_android_portfolios_info('$id','$locale')";

        $resp = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($resp)) {
            $res = array();

            $res['title'] = $row['title'];
            $res['subtitle'] = $row['subtitle'];
            $res['description'] = $row['description'];
            $res['pictures'] = explode('*', $row['pictures']);

            $output[] = $res;
        }

        mysqli_close($conn);
        return $output;
    }

    /**
     * @param $id
     * @param $locale
     * @return array
     */
    private function getFlutterPortfolio($id, $locale)
    {
        $output = array();
        $connectObject = new Connection;
        $conn = $connectObject->connectToDatabase();

        $sql = "CALL sp_select_flutter_portfolios_info('$id','$locale')";

        $resp = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($resp)) {
            $res = array();

            $res['title'] = $row['title'];
            $res['subtitle'] = $row['subtitle'];
            $res['description'] = $row['description'];
            $res['pictures'] = explode('*', $row['pictures']);

            $output[] = $res;
        }

        mysqli_close($conn);
        return $output;
    }
}